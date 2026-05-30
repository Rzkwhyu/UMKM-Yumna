<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokBarang;
use App\Models\Barang;
use App\Models\Suplier;

class StokBarangController extends Controller
{
    public function index()
    {
        $stokbarang = StokBarang::all();

        return view('stokbarang.index', compact('stokbarang'));
    }

    public function create()
    {
        $barang = Barang::all();
        $suplier = Suplier::all();

        return view('stokbarang.create',
            compact('barang', 'suplier'));
    }

    public function store(Request $request)
    {
        StokBarang::create($request->all());
         $barang = Barang::findOrFail($request->barang_id);
         $barang->stok += $request->qty;
         $barang->save();
        return redirect('/stokbarang')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $stokbarang = StokBarang::findOrFail($id);

        $barang = Barang::all();
        $suplier = Suplier::all();

        return view('stokbarang.edit',compact('stokbarang', 'barang', 'suplier'));
    }

    public function update(Request $request, $id)
    {
        $stokbarang = StokBarang::findOrFail($id);

        $stokbarang->update($request->all());

        return redirect('/stokbarang')
            ->with('success', 'Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        $stokbarang = StokBarang::findOrFail($id);

        $stokbarang->delete();

        return redirect('/stokbarang')
            ->with('success', 'Data Berhasil Dihapus');
    }
}