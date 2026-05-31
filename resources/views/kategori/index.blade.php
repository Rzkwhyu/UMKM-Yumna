@extends('layouts.yumna')

@section('body-class', 'page-yumna page-kategori')

@section('title', 'Kategori Barang — Yumna')

@section('header-toolbar')
    <select class="filter-select" id="filterKategori">
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
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <h2>Kategori Barang</h2>
                <p>Kelola kategori untuk pengelompokan barang</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="kategori-list" id="kategoriList">
            @forelse ($kategori as $item)
                @php $style = $resolveIcon($item->kategori); @endphp
                <article
                    class="kategori-row"
                    data-kategori-id="{{ $item->id }}"
                    data-kategori-name="{{ strtolower($item->kategori) }}"
                >
                    <div class="kat-icon" style="background: {{ $style['bg'] }};">
                        <i class="fa-solid {{ $style['icon'] }}"></i>
                    </div>
                    <div class="kat-info">
                        <h3>{{ $item->kategori }}</h3>
                        <span>{{ $item->barang_count }} Barang</span>
                    </div>
                    <div class="kat-actions">
                        <a href="{{ route('kategori.edit', $item->id) }}" class="btn-edit">Edit</a>
                        <form
                            action="{{ route('kategori.destroy', $item->id) }}"
                            method="POST"
                            class="kat-form-delete"
                            onsubmit="return confirm('Hapus kategori ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="empty-kategori">Belum ada kategori. Klik <strong>+ Tambah</strong> untuk membuat kategori baru.</p>
            @endforelse
        </div>
    </section>

    @include('partials.yumna-sidebar-pills')
</div>

@include('partials.kategori-modal-tambah')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('filterKategori');
        const search = document.getElementById('yumnaSearchInput');
        const rows = document.querySelectorAll('.kategori-row');

        function applyFilters() {
            const selectedId = filter ? filter.value : '';
            const query = search ? search.value.trim().toLowerCase() : '';

            rows.forEach(function (row) {
                const matchId = !selectedId || row.dataset.kategoriId === selectedId;
                const matchSearch = !query || row.dataset.kategoriName.includes(query);
                row.classList.toggle('is-hidden', !(matchId && matchSearch));
            });
        }

        if (filter) {
            filter.addEventListener('change', applyFilters);
        }

        if (search) {
            search.addEventListener('input', applyFilters);
        }

        const overlay = document.getElementById('kategoriModalOverlay');
        const btnBuka = document.getElementById('btnBukaModalTambah');
        const btnTutup = document.getElementById('btnTutupModal');
        const formTambah = document.getElementById('formTambahKategori');
        const inputKategori = document.getElementById('inputKategori');

        function bukaModal() {
            if (!overlay) return;
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
            if (inputKategori) {
                inputKategori.focus();
            }
        }

        function tutupModal() {
            if (!overlay) return;
            overlay.classList.remove('is-open');
            overlay.setAttribute('aria-hidden', 'true');
            if (formTambah) {
                formTambah.reset();
            }
        }

        if (btnBuka) {
            btnBuka.addEventListener('click', bukaModal);
        }

        if (btnTutup) {
            btnTutup.addEventListener('click', tutupModal);
        }

        if (overlay) {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) {
                    tutupModal();
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && overlay && overlay.classList.contains('is-open')) {
                tutupModal();
            }
        });
    });
</script>
@endpush
