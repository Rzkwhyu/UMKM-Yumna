@extends('layouts.yumna')

@section('body-class', 'page-yumna page-stokbarang')

@section('title', 'Stok Barang — Yumna')

@section('header-toolbar')
    <select class="filter-select" id="filterStokBarang">
        <option value="">Barang : Semua</option>
        @foreach ($barang as $item)
            <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
        @endforeach
    </select>
    <select class="filter-select" id="filterStokSuplier">
        <option value="">Supplier : Semua</option>
        @foreach ($suplier as $item)
            <option value="{{ $item->id }}">{{ $item->nama_pt }}</option>
        @endforeach
    </select>
    <button type="button" class="btn-tambah" id="btnBukaModalTambah">
        <i class="fa-solid fa-plus"></i> Tambah
    </button>
@endsection

@push('styles')
    @include('partials.yumna-sidebar-styles')
    @include('partials.kategori-page-styles')
    @include('partials.kategori-modal-styles')
@endpush

@section('content')
@php
    $bulanSingkat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    $iconStyles = [
        ['icon' => 'fa-wheat-awn', 'bg' => '#ebe4d4'],
        ['icon' => 'fa-bottle-droplet', 'bg' => '#fff3d6'],
        ['icon' => 'fa-cube', 'bg' => '#fce8ee'],
        ['icon' => 'fa-bowl-food', 'bg' => '#e3f0fc'],
        ['icon' => 'fa-mug-hot', 'bg' => '#e5f5e8'],
        ['icon' => 'fa-pump-soap', 'bg' => '#efe8f8'],
    ];

    $iconKeywords = [
        'beras' => 0,
        'minyak' => 1,
        'lemak' => 1,
        'gula' => 2,
        'pemanis' => 2,
        'makanan' => 3,
        'instan' => 3,
        'mie' => 3,
        'minuman' => 4,
        'teh' => 4,
        'kopi' => 4,
        'pembersih' => 5,
        'deterjen' => 5,
        'sabun' => 5,
    ];

    $resolveIcon = function (string $name) use ($iconStyles, $iconKeywords) {
        $lower = strtolower($name);
        foreach ($iconKeywords as $keyword => $index) {
            if (str_contains($lower, $keyword)) {
                return $iconStyles[$index];
            }
        }
        return $iconStyles[crc32($lower) % count($iconStyles)];
    };
@endphp

<div class="kategori-split">
    <section class="kategori-panel">
        <div class="kategori-panel-head">
            <div class="kategori-panel-icon">
                <i class="fa-solid fa-dolly"></i>
            </div>
            <div>
                <h2>Stok Barang</h2>
                <p>Catat barang masuk dari supplier ke inventori</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="kategori-list" id="stokBarangList">
            @forelse ($stokbarang as $item)
                @php
                    $namaBarang = $item->barang->nama_barang ?? '-';
                    $namaSuplier = $item->suplier->nama_pt ?? '-';
                    $style = $resolveIcon($namaBarang);
                    $tanggal = \Carbon\Carbon::parse($item->tanggal_masuk);
                    $searchText = strtolower(implode(' ', [
                        $namaBarang,
                        $item->no_transaksi,
                        $namaSuplier,
                    ]));
                @endphp
                <article
                    class="kategori-row"
                    data-stok-barang-id="{{ $item->barang_id }}"
                    data-stok-suplier-id="{{ $item->suplier_id }}"
                    data-stok-search="{{ $searchText }}"
                >
                    <div class="kat-icon" style="background: {{ $style['bg'] }};">
                        @if ($item->barang && $item->barang->gambar)
                            <img src="{{ asset($item->barang->gambar) }}" alt="{{ $namaBarang }}" class="kat-logo">
                        @else
                            <i class="fa-solid {{ $style['icon'] }}"></i>
                        @endif
                    </div>
                    <div class="kat-info">
                        <h3>{{ $namaBarang }}</h3>
                        <span>
                            {{ $tanggal->format('d') }}
                            {{ $bulanSingkat[$tanggal->month - 1] }}
                            {{ $tanggal->format('Y') }}
                            · {{ $item->no_transaksi }}
                            · {{ $namaSuplier }}
                            · Qty {{ $item->qty }}
                        </span>
                    </div>
                    <div class="kat-actions">
                        <button
                            type="button"
                            class="btn-edit btn-edit-stokbarang"
                            data-barang-id="{{ $item->barang_id }}"
                            data-tanggal-masuk="{{ $item->tanggal_masuk }}"
                            data-no-transaksi="{{ $item->no_transaksi }}"
                            data-suplier-id="{{ $item->suplier_id }}"
                            data-qty="{{ $item->qty }}"
                            data-update-url="{{ route('stokbarang.update', $item->id) }}"
                        >Edit</button>
                        <form
                            action="{{ route('stokbarang.destroy', $item->id) }}"
                            method="POST"
                            class="kat-form-delete"
                            onsubmit="return confirm('Hapus data barang masuk ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="empty-kategori">Belum ada barang masuk. Klik <strong>+ Tambah</strong> untuk mencatat stok baru.</p>
            @endforelse
        </div>
    </section>

    @include('partials.yumna-sidebar-pills')
</div>

@include('partials.stokbarang-modal-tambah')
@include('partials.stokbarang-modal-edit')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterBarang = document.getElementById('filterStokBarang');
        const filterSuplier = document.getElementById('filterStokSuplier');
        const search = document.getElementById('yumnaSearchInput');
        const rows = document.querySelectorAll('.kategori-row');

        function applyFilters() {
            const selectedBarangId = filterBarang ? filterBarang.value : '';
            const selectedSuplierId = filterSuplier ? filterSuplier.value : '';
            const query = search ? search.value.trim().toLowerCase() : '';

            rows.forEach(function (row) {
                const matchBarang = !selectedBarangId || row.dataset.stokBarangId === selectedBarangId;
                const matchSuplier = !selectedSuplierId || row.dataset.stokSuplierId === selectedSuplierId;
                const matchSearch = !query || row.dataset.stokSearch.includes(query);
                row.classList.toggle('is-hidden', !(matchBarang && matchSuplier && matchSearch));
            });
        }

        if (filterBarang) {
            filterBarang.addEventListener('change', applyFilters);
        }

        if (filterSuplier) {
            filterSuplier.addEventListener('change', applyFilters);
        }

        if (search) {
            search.placeholder = 'Cari barang masuk...';
            search.addEventListener('input', applyFilters);
        }

        const overlay = document.getElementById('stokBarangModalOverlay');
        const editOverlay = document.getElementById('stokBarangEditModalOverlay');
        const btnBuka = document.getElementById('btnBukaModalTambah');
        const btnTutup = document.getElementById('btnTutupModalStokBarang');
        const btnTutupEdit = document.getElementById('btnTutupModalEditStokBarang');
        const formTambah = document.getElementById('formTambahStokBarang');
        const formEdit = document.getElementById('formEditStokBarang');
        const editInputBarangId = document.getElementById('editInputStokBarangId');
        const editInputTanggalMasuk = document.getElementById('editInputTanggalMasuk');
        const editInputSuplierId = document.getElementById('editInputSuplierId');
        const editInputQty = document.getElementById('editInputQtyStok');
        const editNoTransaksiLabel = document.getElementById('editNoTransaksiLabel');
        const editButtons = document.querySelectorAll('.btn-edit-stokbarang');

        function bukaModalTambah() {
            if (!overlay) return;
            tutupModalEdit();
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
        }

        function tutupModalTambah() {
            if (!overlay) return;
            overlay.classList.remove('is-open');
            overlay.setAttribute('aria-hidden', 'true');
            if (formTambah) {
                formTambah.reset();
            }
        }

        function bukaModalEdit(data) {
            if (!editOverlay || !formEdit) return;
            tutupModalTambah();

            formEdit.action = data.updateUrl;
            if (editInputBarangId) editInputBarangId.value = data.barangId || '';
            if (editInputTanggalMasuk) editInputTanggalMasuk.value = data.tanggalMasuk || '';
            if (editInputSuplierId) editInputSuplierId.value = data.suplierId || '';
            if (editInputQty) editInputQty.value = data.qty ?? 1;
            if (editNoTransaksiLabel) editNoTransaksiLabel.textContent = data.noTransaksi || '-';

            editOverlay.classList.add('is-open');
            editOverlay.setAttribute('aria-hidden', 'false');
        }

        function tutupModalEdit() {
            if (!editOverlay) return;
            editOverlay.classList.remove('is-open');
            editOverlay.setAttribute('aria-hidden', 'true');
            if (formEdit) {
                formEdit.reset();
            }
        }

        if (btnBuka) {
            btnBuka.addEventListener('click', bukaModalTambah);
        }

        if (btnTutup) {
            btnTutup.addEventListener('click', tutupModalTambah);
        }

        if (btnTutupEdit) {
            btnTutupEdit.addEventListener('click', tutupModalEdit);
        }

        editButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                bukaModalEdit({
                    updateUrl: btn.dataset.updateUrl,
                    barangId: btn.dataset.barangId,
                    tanggalMasuk: btn.dataset.tanggalMasuk,
                    noTransaksi: btn.dataset.noTransaksi,
                    suplierId: btn.dataset.suplierId,
                    qty: btn.dataset.qty,
                });
            });
        });

        if (overlay) {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) {
                    tutupModalTambah();
                }
            });
        }

        if (editOverlay) {
            editOverlay.addEventListener('click', function (e) {
                if (e.target === editOverlay) {
                    tutupModalEdit();
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                if (overlay && overlay.classList.contains('is-open')) {
                    tutupModalTambah();
                }
                if (editOverlay && editOverlay.classList.contains('is-open')) {
                    tutupModalEdit();
                }
            }
        });
    });
</script>
@endpush
