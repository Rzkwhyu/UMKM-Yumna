<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $suplier = Suplier::withCount('stokBarang')->orderBy('nama_pt')->get();

        $editSuplier = null;
        if ($request->filled('id') && ($request->get('modal') === 'edit' || $request->session()->has('errors'))) {
            $editSuplier = Suplier::find($request->get('id'));
        }

        return view('suplier.index', compact('suplier', 'editSuplier'));
    }

    public function create()
    {
        return redirect()->route('suplier.index', ['modal' => 'tambah']);
    }

    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nama_pt' => 'required|string|max:255',
            'no_telp' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ], [
            'nama_pt.required' => 'Nama PT wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPEG, PNG, GIF, atau WEBP.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('suplier.index', ['modal' => 'tambah'])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['logo'] = $this->storeLogo($request);

        Suplier::create($validated);

        return redirect()
            ->route('suplier.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return redirect()->route('suplier.index', ['modal' => 'edit', 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $suplier = Suplier::findOrFail($id);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nama_pt' => 'required|string|max:255',
            'no_telp' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ], [
            'nama_pt.required' => 'Nama PT wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'logo.image' => 'Logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPEG, PNG, GIF, atau WEBP.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('suplier.index', ['modal' => 'edit', 'id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        if ($request->hasFile('logo')) {
            $this->deleteLogo($suplier->logo);
            $validated['logo'] = $this->storeLogo($request);
        } else {
            unset($validated['logo']);
        }

        $suplier->update($validated);

        return redirect()
            ->route('suplier.index')
            ->with('success', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $suplier = Suplier::findOrFail($id);
        $this->deleteLogo($suplier->logo);
        $suplier->delete();

        return redirect()
            ->back()
            ->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Simpan file logo supplier ke folder public/image/suplier.
     *
     * @return string|null Path relatif logo, atau null jika tidak ada file.
     */
    private function storeLogo(Request $request): ?string
    {
        if (! $request->hasFile('logo')) {
            return null;
        }

        $file = $request->file('logo');
        $directory = public_path('image/suplier');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename .= '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'image/suplier/' . $filename;
    }

    /**
     * Hapus file logo dari storage lokal jika ada.
     */
    private function deleteLogo(?string $path): void
    {
        if (! $path) {
            return;
        }

        $fullPath = public_path($path);

        if (is_file($fullPath)) {
            unlink($fullPath);
        }
    }
}
