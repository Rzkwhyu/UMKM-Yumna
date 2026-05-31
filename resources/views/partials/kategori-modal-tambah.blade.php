<div
    class="kategori-modal-overlay {{ ($errors->any() || request('modal') === 'tambah') ? 'is-open' : '' }}"
    id="kategoriModalOverlay"
    aria-hidden="{{ ($errors->any() || request('modal') === 'tambah') ? 'false' : 'true' }}"
>
    <div class="kategori-modal" role="dialog" aria-labelledby="kategoriModalTitle" aria-modal="true">
        <form action="{{ route('kategori.store') }}" method="POST" id="formTambahKategori">
            @csrf

            <div class="kategori-modal-field">
                <input
                    type="text"
                    name="kategori"
                    id="inputKategori"
                    value="{{ old('kategori') }}"
                    placeholder="Masukan Kategori Barang..."
                    autocomplete="off"
                    required
                >
                @error('kategori')
                    <span class="kategori-modal-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="inputDeskripsi">Deskripsi</label>
                <input
                    type="text"
                    name="deskripsi"
                    id="inputDeskripsi"
                    value="{{ old('deskripsi') }}"
                    placeholder="Masukan Deskrip..."
                    autocomplete="off"
                >
            </div>
            @error('deskripsi')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-actions">
                <button type="submit" class="kategori-btn-simpan">Simpan</button>
                <button type="button" class="kategori-btn-hapus" id="btnTutupModal">Hapus</button>
            </div>
        </form>
    </div>
</div>
