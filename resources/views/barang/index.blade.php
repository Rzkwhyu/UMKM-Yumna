@extends('layouts.yumna')

@section('body-class', 'page-yumna page-barang')

@section('title', 'Data Barang — Yumna')

@section('header-toolbar')
    <select class="filter-select" id="filterBarangKategori">
        <option value="">Kategori : Semua</option>
        @foreach ($kategori as $item)
            <option value="{{ $item->id }}">{{ $item->kategori }}</option>
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
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div>
                <h2>Data Barang</h2>
                <p>Kelola daftar barang, harga beli, dan harga jual</p>
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

        <div class="kategori-list" id="barangList">
            @forelse ($barang as $item)
                @php $style = $resolveIcon($item->nama_barang); @endphp
                <article
                    class="kategori-row"
                    data-barang-id="{{ $item->id }}"
                    data-barang-name="{{ strtolower($item->nama_barang) }}"
                    data-barang-kategori-id="{{ $item->kategori_id }}"
                >
                    <div class="kat-icon" style="background: {{ $style['bg'] }};">
                        @if ($item->gambar)
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_barang }}" class="kat-logo">
                        @else
                            <i class="fa-solid {{ $style['icon'] }}"></i>
                        @endif
                    </div>
                    <div class="kat-info">
                        <h3>{{ $item->nama_barang }}</h3>
                        <span>
                            {{ $item->kategori->kategori ?? '-' }}
                            · Stok {{ $item->stok }}
                            · Beli Rp {{ number_format($item->harga_beli, 0, ',', '.') }}
                            · Jual Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="kat-actions">
                        <button
                            type="button"
                            class="btn-edit btn-edit-barang"
                            data-id="{{ $item->id }}"
                            data-nama="{{ $item->nama_barang }}"
                            data-kategori-id="{{ $item->kategori_id }}"
                            data-harga-beli="{{ $item->harga_beli }}"
                            data-harga-jual="{{ $item->harga_jual }}"
                            data-gambar="{{ $item->gambar ? asset($item->gambar) : '' }}"
                            data-update-url="{{ route('barang.update', $item->id) }}"
                        >Edit</button>
                        <form
                            action="{{ route('barang.destroy', $item->id) }}"
                            method="POST"
                            class="kat-form-delete"
                            onsubmit="return confirm('Hapus barang ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="empty-kategori">Belum ada barang. Klik <strong>+ Tambah</strong> untuk menambahkan barang baru.</p>
            @endforelse
        </div>
    </section>

    @include('partials.yumna-sidebar-pills')
</div>

@include('partials.barang-modal-tambah')
@include('partials.barang-modal-edit')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('filterBarangKategori');
        const search = document.getElementById('yumnaSearchInput');
        const rows = document.querySelectorAll('.kategori-row');

        function applyFilters() {
            const selectedId = filter ? filter.value : '';
            const query = search ? search.value.trim().toLowerCase() : '';

            rows.forEach(function (row) {
                const matchId = !selectedId || row.dataset.barangKategoriId === selectedId;
                const matchSearch = !query || row.dataset.barangName.includes(query);
                row.classList.toggle('is-hidden', !(matchId && matchSearch));
            });
        }

        if (filter) {
            filter.addEventListener('change', applyFilters);
        }

        if (search) {
            search.addEventListener('input', applyFilters);
        }

        const overlay = document.getElementById('barangModalOverlay');
        const editOverlay = document.getElementById('barangEditModalOverlay');
        const btnBuka = document.getElementById('btnBukaModalTambah');
        const btnTutup = document.getElementById('btnTutupModalBarang');
        const btnTutupEdit = document.getElementById('btnTutupModalEditBarang');
        const formTambah = document.getElementById('formTambahBarang');
        const formEdit = document.getElementById('formEditBarang');
        const inputNamaBarang = document.getElementById('inputNamaBarang');
        const editInputNamaBarang = document.getElementById('editInputNamaBarang');
        const editInputKategoriId = document.getElementById('editInputKategoriId');
        const editInputHargaBeli = document.getElementById('editInputHargaBeli');
        const editInputHargaJual = document.getElementById('editInputHargaJual');
        const editInputGambar = document.getElementById('editInputGambar');
        const editGambarPreviewWrap = document.getElementById('editGambarPreviewWrap');
        const editGambarPreview = document.getElementById('editGambarPreview');
        const editButtons = document.querySelectorAll('.btn-edit-barang');

        function bukaModalTambah() {
            if (!overlay) return;
            tutupModalEdit();
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
            if (inputNamaBarang) {
                inputNamaBarang.focus();
            }
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
            if (editInputNamaBarang) editInputNamaBarang.value = data.nama || '';
            if (editInputKategoriId) editInputKategoriId.value = data.kategoriId || '';
            if (editInputHargaBeli) editInputHargaBeli.value = data.hargaBeli || '';
            if (editInputHargaJual) editInputHargaJual.value = data.hargaJual || '';
            if (editInputGambar) editInputGambar.value = '';

            if (editGambarPreviewWrap && editGambarPreview) {
                if (data.gambar) {
                    editGambarPreview.src = data.gambar;
                    editGambarPreviewWrap.hidden = false;
                } else {
                    editGambarPreview.src = '';
                    editGambarPreviewWrap.hidden = true;
                }
            }

            editOverlay.classList.add('is-open');
            editOverlay.setAttribute('aria-hidden', 'false');
            if (editInputNamaBarang) {
                editInputNamaBarang.focus();
            }
        }

        function tutupModalEdit() {
            if (!editOverlay) return;
            editOverlay.classList.remove('is-open');
            editOverlay.setAttribute('aria-hidden', 'true');
            if (formEdit) {
                formEdit.reset();
                if (editGambarPreviewWrap) {
                    editGambarPreviewWrap.hidden = true;
                }
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
                    nama: btn.dataset.nama,
                    kategoriId: btn.dataset.kategoriId,
                    hargaBeli: btn.dataset.hargaBeli,
                    hargaJual: btn.dataset.hargaJual,
                    gambar: btn.dataset.gambar,
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
