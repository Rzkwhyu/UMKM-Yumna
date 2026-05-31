<div
    class="kategori-modal-overlay {{ (request('modal') === 'tambah' || ($errors->any() && request('modal') !== 'edit')) ? 'is-open' : '' }}"
    id="barangModalOverlay"
    aria-hidden="{{ (request('modal') === 'tambah' || ($errors->any() && request('modal') !== 'edit')) ? 'false' : 'true' }}"
>
    <div class="kategori-modal kategori-modal--tall" role="dialog" aria-labelledby="barangModalTitle" aria-modal="true">
        <form action="{{ route('barang.store') }}" method="POST" id="formTambahBarang" enctype="multipart/form-data">
            @csrf

            <div class="kategori-modal-field">
                <input
                    type="text"
                    name="nama_barang"
                    id="inputNamaBarang"
                    value="{{ old('nama_barang') }}"
                    placeholder="Masukan Nama Barang..."
                    autocomplete="off"
                    required
                >
                @error('nama_barang')
                    <span class="kategori-modal-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="inputKategoriId">Kategori</label>
                <select name="kategori_id" id="inputKategoriId" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" {{ (string) old('kategori_id') === (string) $item->id ? 'selected' : '' }}>
                            {{ $item->kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('kategori_id')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="inputHargaBeli">Harga Beli</label>
                <input
                    type="number"
                    name="harga_beli"
                    id="inputHargaBeli"
                    value="{{ old('harga_beli') }}"
                    placeholder="Masukan Harga Beli..."
                    min="0"
                    required
                >
            </div>
            @error('harga_beli')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="inputHargaJual">Harga Jual</label>
                <input
                    type="number"
                    name="harga_jual"
                    id="inputHargaJual"
                    value="{{ old('harga_jual') }}"
                    placeholder="Masukan Harga Jual..."
                    min="0"
                    required
                >
            </div>
            @error('harga_jual')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row kategori-modal-field--file">
                <label for="inputGambar">Gambar</label>
                <input
                    type="file"
                    name="gambar"
                    id="inputGambar"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                >
            </div>
            @error('gambar')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-actions">
                <button type="submit" class="kategori-btn-simpan">Simpan</button>
                <button type="button" class="kategori-btn-hapus" id="btnTutupModalBarang">Hapus</button>
            </div>
        </form>
    </div>
</div>
