@php
    $shouldOpenEdit = $editStokBarang && (request('modal') === 'edit' || $errors->any());
@endphp

<div
    class="kategori-modal-overlay {{ $shouldOpenEdit ? 'is-open' : '' }}"
    id="stokBarangEditModalOverlay"
    aria-hidden="{{ $shouldOpenEdit ? 'false' : 'true' }}"
>
    <div class="kategori-modal kategori-modal--tall" role="dialog" aria-labelledby="stokBarangEditModalTitle" aria-modal="true">
        <form
            action="{{ $editStokBarang ? route('stokbarang.update', $editStokBarang->id) : '#' }}"
            method="POST"
            id="formEditStokBarang"
        >
            @csrf
            @method('PUT')

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="editInputStokBarangId">Barang</label>
                <select name="barang_id" id="editInputStokBarangId" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($barang as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ (string) old('barang_id', $editStokBarang->barang_id ?? '') === (string) $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('barang_id')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="editInputTanggalMasuk">Tanggal</label>
                <input
                    type="date"
                    name="tanggal_masuk"
                    id="editInputTanggalMasuk"
                    value="{{ old('tanggal_masuk', optional($editStokBarang)->tanggal_masuk) }}"
                    required
                >
            </div>
            @error('tanggal_masuk')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label>No. Transaksi</label>
                <span class="kategori-modal-readonly" id="editNoTransaksiLabel">{{ optional($editStokBarang)->no_transaksi ?? '-' }}</span>
            </div>

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="editInputSuplierId">Supplier</label>
                <select name="suplier_id" id="editInputSuplierId" required>
                    <option value="">Pilih Supplier</option>
                    @foreach ($suplier as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ (string) old('suplier_id', optional($editStokBarang)->suplier_id) === (string) $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama_pt }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('suplier_id')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="editInputQtyStok">Qty</label>
                <input
                    type="number"
                    name="qty"
                    id="editInputQtyStok"
                    value="{{ old('qty', optional($editStokBarang)->qty ?? 1) }}"
                    placeholder="Masukan Qty..."
                    min="1"
                    required
                >
            </div>
            @error('qty')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-actions">
                <button type="submit" class="kategori-btn-simpan">Simpan</button>
                <button type="button" class="kategori-btn-hapus" id="btnTutupModalEditStokBarang">Hapus</button>
            </div>
        </form>
    </div>
</div>
