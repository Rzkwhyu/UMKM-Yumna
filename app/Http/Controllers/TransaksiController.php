<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transaksi = Transaksi::with('barang')->latest()->get();

        $riwayatTransaksi = $transaksi
            ->groupBy(fn ($item) => $item->no_transaksi ?: 'legacy-' . $item->id)
            ->map(function ($items) {
                $first = $items->first();

                $itemDetails = $items->map(function ($item) {
                    $hargaAsli = $item->qty > 0
                        ? (int) round($item->total_harga / $item->qty)
                        : 0;

                    return (object) [
                        'nama' => $item->barang?->nama_barang ?? '—',
                        'harga_asli' => $hargaAsli,
                        'qty' => $item->qty,
                        'subtotal' => $item->total_harga,
                    ];
                });

                $searchParts = [
                    $first->no_transaksi,
                    $first->nama_pembeli,
                    $itemDetails->pluck('nama')->implode(' '),
                ];

                return (object) [
                    'no_transaksi' => $first->no_transaksi,
                    'label_nota' => $first->no_transaksi ?: ('#' . str_pad($first->id, 4, '0', STR_PAD_LEFT)),
                    'tanggal' => $first->created_at,
                    'nama_pembeli' => $first->nama_pembeli,
                    'item_details' => $itemDetails,
                    'total_qty' => $items->sum('qty'),
                    'total_harga' => $items->sum('total_harga'),
                    'jumlah_item' => $items->count(),
                    'is_grouped' => filled($first->no_transaksi),
                    'first_id' => $first->id,
                    'search_text' => strtolower(implode(' ', $searchParts)),
                ];
            })
            ->sortByDesc(fn ($group) => $group->tanggal)
            ->values();

        return view('transaksi.index', compact('riwayatTransaksi'));
    }

    public function create()
    {
        $barang = Barang::with('kategori')->orderBy('nama_barang')->get();
        $kategori = Kategori::orderBy('kategori')->get();

        return view('transaksi.create', compact('barang', 'kategori'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.qty' => 'required|integer|min:1',
            'uang_bayar' => 'required|integer|min:0',
            'nama_pembeli' => 'nullable|string|max:255',
        ], [
            'items.required' => 'Pilih minimal satu barang.',
            'items.min' => 'Pilih minimal satu barang.',
            'items.*.barang_id.required' => 'Barang tidak valid.',
            'items.*.qty.required' => 'Jumlah barang wajib diisi.',
            'items.*.qty.min' => 'Jumlah barang minimal 1.',
            'uang_bayar.required' => 'Jumlah uang wajib diisi.',
            'uang_bayar.min' => 'Jumlah uang tidak boleh negatif.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('transaksi.create')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $items = collect($validated['items']);
        $namaPembeli = $validated['nama_pembeli'] ?: 'Pelanggan Umum';

        $barangIds = $items->pluck('barang_id')->unique()->values();
        $barangMap = Barang::whereIn('id', $barangIds)->get()->keyBy('id');

        $total = 0;
        foreach ($items as $item) {
            $barang = $barangMap->get($item['barang_id']);
            if (! $barang) {
                return redirect()
                    ->route('transaksi.create')
                    ->with('error', 'Barang tidak ditemukan.');
            }

            if ($item['qty'] > $barang->stok) {
                return redirect()
                    ->route('transaksi.create')
                    ->with('error', 'Stok ' . $barang->nama_barang . ' tidak mencukupi.');
            }

            $total += $barang->harga * $item['qty'];
        }

        if ($validated['uang_bayar'] < $total) {
            return redirect()
                ->route('transaksi.create')
                ->with('error', 'Jumlah uang pembayaran kurang dari total belanja.');
        }

        $noTransaksi = $this->generateNoTransaksi();

        DB::transaction(function () use ($items, $barangMap, $namaPembeli, $noTransaksi) {
            foreach ($items as $item) {
                $barang = $barangMap->get($item['barang_id']);
                $lineTotal = $barang->harga * $item['qty'];

                Transaksi::create([
                    'no_transaksi' => $noTransaksi,
                    'barang_id' => $barang->id,
                    'nama_pembeli' => $namaPembeli,
                    'qty' => $item['qty'],
                    'total_harga' => $lineTotal,
                ]);

                $barang->stok -= $item['qty'];
                $barang->save();
            }
        });

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi ' . $noTransaksi . ' berhasil dicatat.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barang = Barang::orderBy('nama_barang')->get();

        return view('transaksi.edit', compact('transaksi', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($request->barang_id);
        $total = $barang->harga * $request->qty;
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'barang_id' => $request->barang_id,
            'nama_pembeli' => $request->nama_pembeli,
            'qty' => $request->qty,
            'total_harga' => $total,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function destroyNota(Request $request)
    {
        $request->validate([
            'no_transaksi' => 'required|string|max:255',
        ]);

        $deleted = Transaksi::where('no_transaksi', $request->no_transaksi)->delete();

        if ($deleted === 0) {
            return redirect()
                ->route('transaksi.index')
                ->with('error', 'Transaksi tidak ditemukan.');
        }

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi ' . $request->no_transaksi . ' berhasil dihapus.');
    }

    public function cetakNota(Request $request)
    {
        $items = $this->resolveNotaItems($request);
        $nota = $this->buildNotaData($items);

        return view('transaksi.cetak-nota', compact('nota'));
    }

    /**
     * Ambil item transaksi berdasarkan nomor nota atau id legacy.
     */
    private function resolveNotaItems(Request $request)
    {
        if ($request->filled('no')) {
            $items = Transaksi::with('barang')
                ->where('no_transaksi', $request->query('no'))
                ->orderBy('id')
                ->get();
        } elseif ($request->filled('id')) {
            $item = Transaksi::with('barang')->findOrFail($request->query('id'));
            $items = collect([$item]);
        } else {
            abort(404);
        }

        if ($items->isEmpty()) {
            abort(404);
        }

        return $items;
    }

    /**
     * Susun data nota thermal untuk dicetak.
     */
    private function buildNotaData($items): object
    {
        $first = $items->first();
        $charWidth = 32;

        $itemLines = $items->map(function ($item) use ($charWidth) {
            $hargaAsli = $item->qty > 0
                ? (int) round($item->total_harga / $item->qty)
                : 0;
            $nama = $item->barang?->nama_barang ?? '-';

            return (object) [
                'nama' => $nama,
                'qty' => $item->qty,
                'harga_asli' => $hargaAsli,
                'subtotal' => $item->total_harga,
                'line' => $this->formatReceiptItemLine($nama, $item->qty, $hargaAsli, $item->total_harga, $charWidth),
            ];
        });

        $labelNota = $first->no_transaksi ?: ('#' . str_pad($first->id, 4, '0', STR_PAD_LEFT));
        $totalHarga = (int) $items->sum('total_harga');

        return (object) [
            'garis' => str_repeat('-', $charWidth),
            'no_transaksi' => $labelNota,
            'meta_line' => $first->created_at->format('d.m.y-H:i')
                . '/' . $labelNota
                . '/' . auth()->user()->name,
            'nama_pembeli' => $first->nama_pembeli,
            'items' => $itemLines,
            'total_qty' => $items->sum('qty'),
            'total_harga' => $totalHarga,
            'harga_jual_line' => $this->formatReceiptTotalLine('HARGA JUAL', $totalHarga, $charWidth),
            'total_line' => $this->formatReceiptTotalLine('TOTAL', $totalHarga, $charWidth),
            'tunai_line' => $this->formatReceiptTotalLine('TUNAI', $totalHarga, $charWidth),
        ];
    }

    /**
     * Format satu baris item nota thermal.
     */
    private function formatReceiptItemLine(string $nama, int $qty, int $harga, int $subtotal, int $width = 32): string
    {
        $nama = mb_strimwidth($nama, 0, 14, '', 'UTF-8');
        $qtyStr = str_pad((string) $qty, 2, ' ', STR_PAD_LEFT);
        $hargaStr = str_pad(number_format($harga, 0, ',', ','), 5, ' ', STR_PAD_LEFT);
        $subtotalStr = str_pad(number_format($subtotal, 0, ',', ','), 7, ' ', STR_PAD_LEFT);

        return sprintf('%-14s %2s %5s %7s', $nama, $qtyStr, $hargaStr, $subtotalStr);
    }

    /**
     * Format baris total nota thermal dengan rata kanan.
     */
    private function formatReceiptTotalLine(string $label, int $amount, int $width = 32): string
    {
        $value = number_format($amount, 0, ',', ',');
        $labelPart = $label . ' :';

        return $labelPart . str_repeat(' ', max(1, $width - mb_strlen($labelPart) - mb_strlen($value))) . $value;
    }

    /**
     * Generate nomor transaksi unik harian.
     */
    private function generateNoTransaksi(): string
    {
        $prefix = 'TRX-' . now()->format('Ymd');
        $last = Transaksi::where('no_transaksi', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('no_transaksi');

        $sequence = 1;
        if ($last && preg_match('/-(\d+)$/', $last, $matches)) {
            $sequence = ((int) $matches[1]) + 1;
        }

        return $prefix . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
