<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $barang = Barang::with('kategori')->orderBy('nama_barang')->get();
        $kategori = Kategori::orderBy('kategori')->get();

        $editBarang = null;
        if ($request->filled('id') && ($request->get('modal') === 'edit' || $request->session()->has('errors'))) {
            $editBarang = Barang::find($request->get('id'));
        }

        return view('barang.index', compact('barang', 'kategori', 'editBarang'));
    }

    public function create()
    {
        return redirect()->route('barang.index', ['modal' => 'tambah']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return redirect()
                ->route('barang.index', ['modal' => 'tambah'])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['stok'] = 0;
        $validated['gambar'] = $this->storeGambar($request);

        Barang::create($validated);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return redirect()->route('barang.index', ['modal' => 'edit', 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validator = Validator::make($request->all(), $this->rules(), $this->messages());

        if ($validator->fails()) {
            return redirect()
                ->route('barang.index', ['modal' => 'edit', 'id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        if ($request->hasFile('gambar')) {
            $this->deleteGambar($barang->gambar);
            $validated['gambar'] = $this->storeGambar($request);
        } else {
            unset($validated['gambar']);
        }

        $barang->update($validated);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data berhasil diubah.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $this->deleteGambar($barang->gambar);
        $barang->delete();

        return redirect()
            ->back()
            ->with('success', 'Data berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function rules(): array
    {
        return [
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga_beli' => 'required|integer|min:0',
            'harga_jual' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048',
        ];
    }

    /**
     * @return array<string, string>
     */
    private function messages(): array
    {
        return [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.integer' => 'Harga beli harus berupa angka.',
            'harga_beli.min' => 'Harga beli tidak boleh negatif.',
            'harga_jual.required' => 'Harga jual wajib diisi.',
            'harga_jual.integer' => 'Harga jual harus berupa angka.',
            'harga_jual.min' => 'Harga jual tidak boleh negatif.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.mimes' => 'Gambar harus berformat JPEG, PNG, GIF, atau WEBP.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    /**
     * Simpan file gambar barang ke folder public/image/barang.
     *
     * @return string|null Path relatif gambar, atau null jika tidak ada file.
     */
    private function storeGambar(Request $request): ?string
    {
        if (! $request->hasFile('gambar')) {
            return null;
        }

        $file = $request->file('gambar');
        $directory = public_path('image/barang');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename .= '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'image/barang/' . $filename;
    }

    /**
     * Hapus file gambar dari storage lokal jika ada.
     */
    private function deleteGambar(?string $path): void
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
