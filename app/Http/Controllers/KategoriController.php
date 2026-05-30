<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(){
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    public function create(){
        return view ('kategori.create');
    }

    public function store(Request $request){
         Kategori::create($request->all());

         return redirect('/kategori')
            ->with('success', 'Data Berhasil Ditambahkan');
    }


     public function edit($id){
        $kategori = Kategori::findOrFail($id);

    return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id){
    $kategori = Kategori::findOrFail($id);
    $kategori->update($request->all());
    return redirect('/kategori')->with('success', 'Data Berhasil Di Ubah');
    }

    public function destroy($id){
        $kategori= Kategori::FindOrFail($id);
        $kategori->delete();
        return redirect()->back()->with('success', 'Data Berhasil Di Hapus');
    }
}
