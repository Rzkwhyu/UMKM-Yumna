<div
    class="kategori-modal-overlay {{ (request('modal') === 'tambah' || ($errors->any() && request('modal') !== 'edit')) ? 'is-open' : '' }}"
    id="suplierModalOverlay"
    aria-hidden="{{ (request('modal') === 'tambah' || ($errors->any() && request('modal') !== 'edit')) ? 'false' : 'true' }}"
>
    <div class="kategori-modal" role="dialog" aria-labelledby="suplierModalTitle" aria-modal="true">
        <form action="{{ route('suplier.store') }}" method="POST" id="formTambahSuplier" enctype="multipart/form-data">
            @csrf

            <div class="kategori-modal-field">
                <input
                    type="text"
                    name="nama_pt"
                    id="inputNamaPt"
                    value="{{ old('nama_pt') }}"
                    placeholder="Masukan Nama PT..."
                    autocomplete="off"
                    required
                >
                @error('nama_pt')
                    <span class="kategori-modal-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="inputNoTelp">No Telp</label>
                <input
                    type="text"
                    name="no_telp"
                    id="inputNoTelp"
                    value="{{ old('no_telp') }}"
                    placeholder="Masukan No Telp..."
                    autocomplete="off"
                    required
                >
            </div>
            @error('no_telp')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row kategori-modal-field--file">
                <label for="inputLogo">Logo</label>
                <input
                    type="file"
                    name="logo"
                    id="inputLogo"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                >
            </div>
            @error('logo')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-actions">
                <button type="submit" class="kategori-btn-simpan">Simpan</button>
                <button type="button" class="kategori-btn-hapus" id="btnTutupModalSuplier">Hapus</button>
            </div>
        </form>
    </div>
</div>
