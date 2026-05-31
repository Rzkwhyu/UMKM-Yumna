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
        $transaksi = Transaksi::with('barang')
            ->latest()
            ->get();

        return view('transaksi.index', compact('transaksi'));
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
