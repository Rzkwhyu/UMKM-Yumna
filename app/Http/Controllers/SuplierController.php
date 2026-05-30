<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suplier;

class SuplierController extends Controller
{
    public function index()
    {
        $suplier = Suplier::all();

        return view('suplier.index', compact('suplier'));
    }

    public function create()
    {
        return view('suplier.create');
    }

    public function store(Request $request)
    {
        Suplier::create($request->all());

        return redirect('/suplier')
            ->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $suplier = Suplier::findOrFail($id);

        return view('suplier.edit', compact('suplier'));
    }

    public function update(Request $request, $id)
    {
        $suplier = Suplier::findOrFail($id);

        $suplier->update($request->all());

        return redirect('/suplier')
            ->with('success', 'Data Berhasil Diubah');
    }

    public function destroy($id)
    {
        $suplier = Suplier::findOrFail($id);

        $suplier->delete();

        return redirect('/suplier')
            ->with('success', 'Data Berhasil Dihapus');
    }
}