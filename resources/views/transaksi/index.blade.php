@extends('layouts.yumna')

@section('body-class', 'page-yumna page-transaksi')

@section('title', 'Riwayat Transaksi — Yumna')

@section('header-toolbar')
    <a href="{{ route('transaksi.create') }}" class="btn-tambah">
        <i class="fa-solid fa-plus"></i> Tambah Transaksi
    </a>
@endsection

@push('styles')
    @include('partials.transaksi-page-styles')
@endpush

@section('content')
@php
    $bulanSingkat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
@endphp

<div class="transaksi-page">
    <section class="transaksi-panel">
        <div class="transaksi-panel-head">
            <div class="transaksi-panel-icon">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <h2>Riwayat Transaksi</h2>
                <p>Daftar semua transaksi penjualan barang</p>
            </div>
            <div class="panel-meta">
                <strong>{{ $transaksi->count() }}</strong>
                Total transaksi
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        <div class="transaksi-table-wrap">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>No. Trx</th>
                        <th>No. Nota</th>
                        <th>Tanggal</th>
                        <th>Pembeli</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="transaksiTableBody">
                    @forelse ($transaksi as $trx)
                        <tr
                            class="trx-row"
                            data-trx-search="{{ strtolower(($trx->no_transaksi ?? '') . ' #' . str_pad($trx->id, 4, '0', STR_PAD_LEFT) . ' ' . $trx->nama_pembeli . ' ' . ($trx->barang?->nama_barang ?? '')) }}"
                        >
                            <td class="trx-id">#{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $trx->no_transaksi ?? '—' }}</td>
                            <td>
                                {{ $trx->created_at->format('d') }}
                                {{ $bulanSingkat[$trx->created_at->month - 1] }}
                                {{ $trx->created_at->format('Y, H:i') }}
                            </td>
                            <td>{{ $trx->nama_pembeli }}</td>
                            <td>{{ $trx->barang?->nama_barang ?? '—' }}</td>
                            <td>{{ $trx->qty }}</td>
                            <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge-selesai">Selesai</span></td>
                            <td>
                                <div class="trx-actions">
                                    <a href="{{ route('transaksi.edit', $trx->id) }}" class="btn-edit">Edit</a>
                                    <form
                                        action="{{ route('transaksi.destroy', $trx->id) }}"
                                        method="POST"
                                        class="trx-form-delete"
                                        onsubmit="return confirm('Hapus transaksi ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-hapus">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty-transaksi">
                                Belum ada riwayat transaksi. Klik <strong>+ Tambah Transaksi</strong> untuk mencatat transaksi baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const search = document.getElementById('yumnaSearchInput');
        const rows = document.querySelectorAll('.trx-row');

        function applySearch() {
            const query = search ? search.value.trim().toLowerCase() : '';

            rows.forEach(function (row) {
                const matchSearch = !query || row.dataset.trxSearch.includes(query);
                row.classList.toggle('is-hidden', !matchSearch);
            });
        }

        if (search) {
            search.placeholder = 'Cari transaksi...';
            search.addEventListener('input', applySearch);
        }
    });
</script>
@endpush
