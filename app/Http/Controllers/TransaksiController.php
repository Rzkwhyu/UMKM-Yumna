<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('barang')
            ->latest()
            ->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = Barang::all();

        return view('transaksi.create',
            compact('barang'));
    }

    public function store(Request $request)
    {
    $barang = Barang::findOrFail($request->barang_id);
    if($request->qty > $barang->stok){
    return redirect()->back()
        ->with('error', 'Stok Tidak Mencukupi');
    }
    $total = $barang->harga * $request->qty;

    Transaksi::create([
        'barang_id' => $request->barang_id,
        'nama_pembeli' => $request->nama_pembeli,
        'qty' => $request->qty,
        'total_harga' => $total
    ]);

    $barang->stok -= $request->qty;

    $barang->save();

    return redirect('/transaksi')
        ->with('success', 'Transaksi Berhasil');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $barang = Barang::all();

        return view('transaksi.edit',
            compact('transaksi', 'barang'));
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
            'total_harga' => $total
        ]);

        return redirect('/transaksi')
            ->with('success', 'Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->delete();

        return redirect('/transaksi')
            ->with('success', 'Data Berhasil Dihapus');
    }
}