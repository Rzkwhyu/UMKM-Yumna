<div
    class="kategori-modal-overlay {{ (request('modal') === 'tambah' || ($errors->any() && request('modal') !== 'edit')) ? 'is-open' : '' }}"
    id="stokBarangModalOverlay"
    aria-hidden="{{ (request('modal') === 'tambah' || ($errors->any() && request('modal') !== 'edit')) ? 'false' : 'true' }}"
>
    <div class="kategori-modal kategori-modal--tall" role="dialog" aria-labelledby="stokBarangModalTitle" aria-modal="true">
        <form action="{{ route('stokbarang.store') }}" method="POST" id="formTambahStokBarang">
            @csrf

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="inputStokBarangId">Barang</label>
                <select name="barang_id" id="inputStokBarangId" required>
                    <option value="">Pilih Barang</option>
                    @foreach ($barang as $item)
                        <option value="{{ $item->id }}" {{ (string) old('barang_id') === (string) $item->id ? 'selected' : '' }}>
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
                <label for="inputTanggalMasuk">Tanggal</label>
                <input
                    type="date"
                    name="tanggal_masuk"
                    id="inputTanggalMasuk"
                    value="{{ old('tanggal_masuk', now()->format('Y-m-d')) }}"
                    required
                >
            </div>
            @error('tanggal_masuk')
                <span class="kategori-modal-error kategori-modal-error--block">{{ $message }}</span>
            @enderror

            <div class="kategori-modal-divider"></div>

            <div class="kategori-modal-field kategori-modal-field--row">
                <label for="inputSuplierId">Supplier</label>
                <select name="suplier_id" id="inputSuplierId" required>
                    <option value="">Pilih Supplier</option>
                    @foreach ($suplier as $item)
                        <option value="{{ $item->id }}" {{ (string) old('suplier_id') === (string) $item->id ? 'selected' : '' }}>
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
                <label for="inputQtyStok">Qty</label>
                <input
                    type="number"
                    name="qty"
                    id="inputQtyStok"
                    value="{{ old('qty', 1) }}"
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
                <button type="button" class="kategori-btn-hapus" id="btnTutupModalStokBarang">Hapus</button>
            </div>
        </form>
    </div>
</div>
