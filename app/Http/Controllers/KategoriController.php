<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $kategori = Kategori::withCount('barang')->orderBy('kategori')->get();

        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return redirect()->route('kategori.index', ['modal' => 'tambah']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()
            ->back()
            ->with('success', 'Data berhasil dihapus.');
    }
}
