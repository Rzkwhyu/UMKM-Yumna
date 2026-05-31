@php
    $shouldOpenEdit = $editSuplier && (request('modal') === 'edit' || $errors->any());
@endphp

<div
    class="kategori-modal-overlay {{ $shouldOpenEdit ? 'is-open' : '' }}"
    id="suplierEditModalOverlay"
    aria-hidden="{{ $shouldOpenEdit ? 'false' : 'true' }}"
>
    <div class="kategori-modal" role="dialog" aria-labelledby="suplierEditModalTitle" aria-modal="true">
        <form
            action="{{ $editSuplier ? route('suplier.update', $editSuplier->id) : '#' }}"
            method="POST"
            id="formEditSuplier"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="kategori-modal-field">
                <input
                    type="text"
                    name="nama_pt"
                    id="editInputNamaPt"
                    value="{{ old('nama_pt', $editSuplier->nama_pt ?? '') }}"
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
                <label for="editInputNoTelp">No Telp</label>
                <input
                    type="text"
                    name="no_telp"
                    id="editInputNoTelp"
                    value="{{ old('no_telp', $editSuplier->no_telp ?? '') }}"
                    placeholder="Masukan No Telp..."
                    autocomplete="off"
                    required
                >
            </div>
            @error('no_telp')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-logo-preview" id="editLogoPreviewWrap" @if(!($editSuplier && $editSuplier->logo)) hidden @endif>
                <img
                    id="editLogoPreview"
                    src="{{ ($editSuplier && $editSuplier->logo) ? asset($editSuplier->logo) : '' }}"
                    alt="Logo supplier"
                >
                <span>Logo saat ini</span>
            </div>

            <div class="kategori-modal-field kategori-modal-field--row kategori-modal-field--file">
                <label for="editInputLogo">Logo</label>
                <input
                    type="file"
                    name="logo"
                    id="editInputLogo"
                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                >
            </div>
            @error('logo')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-actions">
                <button type="submit" class="kategori-btn-simpan">Simpan</button>
                <button type="button" class="kategori-btn-hapus" id="btnTutupModalEditSuplier">Hapus</button>
            </div>
        </form>
    </div>
</div>
