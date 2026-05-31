@extends('layouts.yumna')

@section('body-class', 'page-yumna page-suplier')

@section('title', 'Supplier — Yumna')

@section('header-toolbar')
    <select class="filter-select" id="filterSuplier">
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
    $iconStyles = [
        ['icon' => 'fa-truck', 'bg' => '#ebe4d4'],
        ['icon' => 'fa-building', 'bg' => '#fff3d6'],
        ['icon' => 'fa-warehouse', 'bg' => '#fce8ee'],
        ['icon' => 'fa-boxes-packing', 'bg' => '#e3f0fc'],
        ['icon' => 'fa-industry', 'bg' => '#e5f5e8'],
        ['icon' => 'fa-store', 'bg' => '#efe8f8'],
    ];

    $resolveIcon = function (string $name) use ($iconStyles) {
        return $iconStyles[crc32(strtolower($name)) % count($iconStyles)];
    };
@endphp

<div class="kategori-split">
    <section class="kategori-panel">
        <div class="kategori-panel-head">
            <div class="kategori-panel-icon">
                <i class="fa-solid fa-truck-field"></i>
            </div>
            <div>
                <h2>Supplier</h2>
                <p>Kelola data supplier untuk stok barang</p>
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

        <div class="kategori-list" id="suplierList">
            @forelse ($suplier as $item)
                @php $style = $resolveIcon($item->nama_pt); @endphp
                <article
                    class="kategori-row"
                    data-suplier-id="{{ $item->id }}"
                    data-suplier-name="{{ strtolower($item->nama_pt) }}"
                >
                    <div class="kat-icon" style="background: {{ $style['bg'] }};">
                        @if ($item->logo)
                            <img src="{{ asset($item->logo) }}" alt="{{ $item->nama_pt }}" class="kat-logo">
                        @else
                            <i class="fa-solid {{ $style['icon'] }}"></i>
                        @endif
                    </div>
                    <div class="kat-info">
                        <h3>{{ $item->nama_pt }}</h3>
                        <span>{{ $item->no_telp }} · {{ $item->stok_barang_count }} Stok</span>
                    </div>
                    <div class="kat-actions">
                        <button
                            type="button"
                            class="btn-edit btn-edit-suplier"
                            data-id="{{ $item->id }}"
                            data-nama="{{ $item->nama_pt }}"
                            data-telp="{{ $item->no_telp }}"
                            data-logo="{{ $item->logo ? asset($item->logo) : '' }}"
                            data-update-url="{{ route('suplier.update', $item->id) }}"
                        >Edit</button>
                        <form
                            action="{{ route('suplier.destroy', $item->id) }}"
                            method="POST"
                            class="kat-form-delete"
                            onsubmit="return confirm('Hapus supplier ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="empty-kategori">Belum ada supplier. Klik <strong>+ Tambah</strong> untuk menambahkan supplier baru.</p>
            @endforelse
        </div>
    </section>

    @include('partials.yumna-sidebar-pills')
</div>

@include('partials.suplier-modal-tambah')
@include('partials.suplier-modal-edit')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('filterSuplier');
        const search = document.getElementById('yumnaSearchInput');
        const rows = document.querySelectorAll('.kategori-row');

        function applyFilters() {
            const selectedId = filter ? filter.value : '';
            const query = search ? search.value.trim().toLowerCase() : '';

            rows.forEach(function (row) {
                const matchId = !selectedId || row.dataset.suplierId === selectedId;
                const matchSearch = !query || row.dataset.suplierName.includes(query);
                row.classList.toggle('is-hidden', !(matchId && matchSearch));
            });
        }

        if (filter) {
            filter.addEventListener('change', applyFilters);
        }

        if (search) {
            search.addEventListener('input', applyFilters);
        }

        const overlay = document.getElementById('suplierModalOverlay');
        const editOverlay = document.getElementById('suplierEditModalOverlay');
        const btnBuka = document.getElementById('btnBukaModalTambah');
        const btnTutup = document.getElementById('btnTutupModalSuplier');
        const btnTutupEdit = document.getElementById('btnTutupModalEditSuplier');
        const formTambah = document.getElementById('formTambahSuplier');
        const formEdit = document.getElementById('formEditSuplier');
        const inputNamaPt = document.getElementById('inputNamaPt');
        const editInputNamaPt = document.getElementById('editInputNamaPt');
        const editInputNoTelp = document.getElementById('editInputNoTelp');
        const editInputLogo = document.getElementById('editInputLogo');
        const editLogoPreviewWrap = document.getElementById('editLogoPreviewWrap');
        const editLogoPreview = document.getElementById('editLogoPreview');
        const editButtons = document.querySelectorAll('.btn-edit-suplier');

        function bukaModalTambah() {
            if (!overlay) return;
            tutupModalEdit();
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
            if (inputNamaPt) {
                inputNamaPt.focus();
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
            if (editInputNamaPt) editInputNamaPt.value = data.nama || '';
            if (editInputNoTelp) editInputNoTelp.value = data.telp || '';
            if (editInputLogo) editInputLogo.value = '';

            if (editLogoPreviewWrap && editLogoPreview) {
                if (data.logo) {
                    editLogoPreview.src = data.logo;
                    editLogoPreviewWrap.hidden = false;
                } else {
                    editLogoPreview.src = '';
                    editLogoPreviewWrap.hidden = true;
                }
            }

            editOverlay.classList.add('is-open');
            editOverlay.setAttribute('aria-hidden', 'false');
            if (editInputNamaPt) {
                editInputNamaPt.focus();
            }
        }

        function tutupModalEdit() {
            if (!editOverlay) return;
            editOverlay.classList.remove('is-open');
            editOverlay.setAttribute('aria-hidden', 'true');
            if (formEdit) {
                formEdit.reset();
                if (editLogoPreviewWrap) {
                    editLogoPreviewWrap.hidden = true;
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
                    telp: btn.dataset.telp,
                    logo: btn.dataset.logo,
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
