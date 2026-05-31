<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\StokBarang;
use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StokBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $stokbarang = StokBarang::with(['barang', 'suplier'])
            ->orderByDesc('tanggal_masuk')
            ->orderByDesc('id')
            ->get();

        $barang = Barang::orderBy('nama_barang')->get();
        $suplier = Suplier::orderBy('nama_pt')->get();

        $editStokBarang = null;
        if ($request->filled('id') && ($request->get('modal') === 'edit' || $request->session()->has('errors'))) {
            $editStokBarang = StokBarang::find($request->get('id'));
        }

        return view('stokbarang.index', compact('stokbarang', 'barang', 'suplier', 'editStokBarang'));
    }

    public function create()
    {
        return redirect()->route('stokbarang.index', ['modal' => 'tambah']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return redirect()
                ->route('stokbarang.index', ['modal' => 'tambah'])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['no_transaksi'] = $this->generateNoTransaksi();

        StokBarang::create($validated);

        $barang = Barang::findOrFail($validated['barang_id']);
        $barang->stok += $validated['qty'];
        $barang->save();

        return redirect()
            ->route('stokbarang.index')
            ->with('success', 'Barang masuk berhasil dicatat.');
    }

    public function edit($id)
    {
        return redirect()->route('stokbarang.index', ['modal' => 'edit', 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $stokbarang = StokBarang::findOrFail($id);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return redirect()
                ->route('stokbarang.index', ['modal' => 'edit', 'id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $oldBarang = Barang::findOrFail($stokbarang->barang_id);
        $oldBarang->stok = max(0, $oldBarang->stok - $stokbarang->qty);
        $oldBarang->save();

        $stokbarang->update($validated);

        $newBarang = Barang::findOrFail($validated['barang_id']);
        $newBarang->stok += $validated['qty'];
        $newBarang->save();

        return redirect()
            ->route('stokbarang.index')
            ->with('success', 'Data barang masuk berhasil diubah.');
    }

    public function destroy($id)
    {
        $stokbarang = StokBarang::findOrFail($id);

        $barang = Barang::findOrFail($stokbarang->barang_id);
        $barang->stok = max(0, $barang->stok - $stokbarang->qty);
        $barang->save();

        $stokbarang->delete();

        return redirect()
            ->back()
            ->with('success', 'Data barang masuk berhasil dihapus.');
    }

    /**
     * Aturan validasi form barang masuk.
     *
     * @return array<string, string>
     */
    private function rules(): array
    {
        return [
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_masuk' => 'required|date',
            'suplier_id' => 'required|exists:supliers,id',
            'qty' => 'required|integer|min:1',
        ];
    }

    /**
     * Pesan validasi form barang masuk.
     *
     * @return array<string, string>
     */
    private function messages(): array
    {
        return [
            'barang_id.required' => 'Barang wajib dipilih.',
            'barang_id.exists' => 'Barang tidak valid.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format tanggal masuk tidak valid.',
            'suplier_id.required' => 'Supplier wajib dipilih.',
            'suplier_id.exists' => 'Supplier tidak valid.',
            'qty.required' => 'Qty wajib diisi.',
            'qty.integer' => 'Qty harus berupa angka.',
            'qty.min' => 'Qty minimal 1.',
        ];
    }

    /**
     * Generate nomor transaksi stok masuk unik harian.
     */
    private function generateNoTransaksi(): string
    {
        $prefix = 'STK-' . now()->format('Ymd');
        $last = StokBarang::where('no_transaksi', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('no_transaksi');

        $sequence = 1;
        if ($last && preg_match('/-(\d+)$/', $last, $matches)) {
            $sequence = ((int) $matches[1]) + 1;
        }

        return $prefix . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
