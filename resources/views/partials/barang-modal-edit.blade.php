@php
    $shouldOpenEdit = $editBarang && (request('modal') === 'edit' || $errors->any());
@endphp

<div
    class="kategori-modal-overlay {{ $shouldOpenEdit ? 'is-open' : '' }}"
    id="barangEditModalOverlay"
    aria-hidden="{{ $shouldOpenEdit ? 'false' : 'true' }}"
>
    <div class="kategori-modal kategori-modal--tall" role="dialog" aria-labelledby="barangEditModalTitle" aria-modal="true">
        <form
            action="{{ $editBarang ? route('barang.update', $editBarang->id) : '#' }}"
            method="POST"
            id="formEditBarang"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="kategori-modal-field">
                <input
                    type="text"
                    name="nama_barang"
                    id="editInputNamaBarang"
                    value="{{ old('nama_barang', $editBarang->nama_barang ?? '') }}"
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
                <label for="editInputKategoriId">Kategori</label>
                <select name="kategori_id" id="editInputKategoriId" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ (string) old('kategori_id', $editBarang->kategori_id ?? '') === (string) $item->id ? 'selected' : '' }}
                        >
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
                <label for="editInputHargaBeli">Harga Beli</label>
                <input
                    type="number"
                    name="harga_beli"
                    id="editInputHargaBeli"
                    value="{{ old('harga_beli', $editBarang->harga_beli ?? '') }}"
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
                <label for="editInputHargaJual">Harga Jual</label>
                <input
                    type="number"
                    name="harga_jual"
                    id="editInputHargaJual"
                    value="{{ old('harga_jual', $editBarang->harga_jual ?? '') }}"
                    placeholder="Masukan Harga Jual..."
                    min="0"
                    required
                >
            </div>
            @error('harga_jual')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-logo-preview" id="editGambarPreviewWrap" @if(!($editBarang && $editBarang->gambar)) hidden @endif>
                <img
                    id="editGambarPreview"
                    src="{{ ($editBarang && $editBarang->gambar) ? asset($editBarang->gambar) : '' }}"
                    alt="Gambar barang"
                >
                <span>Gambar saat ini</span>
            </div>

            <div class="kategori-modal-field kategori-modal-field--row kategori-modal-field--file">
                <label for="editInputGambar">Gambar</label>
                <input
                    type="file"
                    name="gambar"
                    id="editInputGambar"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                >
            </div>
            @error('gambar')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-actions">
                <button type="submit" class="kategori-btn-simpan">Simpan</button>
                <button type="button" class="kategori-btn-hapus" id="btnTutupModalEditBarang">Hapus</button>
            </div>
        </form>
    </div>
</div>
