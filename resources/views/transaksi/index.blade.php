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
                <p>Daftar transaksi penjualan</p>
            </div>
            <div class="panel-meta">
                <strong>{{ $riwayatTransaksi->count() }}</strong>
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
                        <th>No. Nota</th>
                        <th>Tanggal</th>
                        <th>Rincian Barang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="transaksiTableBody">
                    @forelse ($riwayatTransaksi as $group)
                        <tr
                            class="trx-row"
                            data-trx-search="{{ $group->search_text }}"
                        >
                            <td class="trx-id">{{ $group->label_nota }}</td>
                            <td>
                                {{ $group->tanggal->format('d') }}
                                {{ $bulanSingkat[$group->tanggal->month - 1] }}
                                {{ $group->tanggal->format('Y, H:i') }}
                            </td>
                            <td class="trx-detail-cell">
                                <table class="trx-item-table">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th>Harga Asli</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($group->item_details as $item)
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>Rp {{ number_format($item->harga_asli, 0, ',', '.') }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td class="trx-foot-meta">
                                                <span class="trx-count-badge">{{ $group->jumlah_item }} item</span>
                                                <span class="trx-qty-total">Qty total: {{ $group->total_qty }}</span>
                                            </td>
                                            <td></td>
                                            <td class="trx-total-label">Total</td>
                                            <td class="trx-total-akumulasi">Rp {{ number_format($group->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                            <td>
                                <div class="trx-actions">
                                    <a
                                        href="{{ route('transaksi.cetak-nota', $group->is_grouped ? ['no' => $group->no_transaksi] : ['id' => $group->first_id]) }}"
                                        target="_blank"
                                        class="btn-cetak-nota"
                                    >
                                        <i class="fa-solid fa-print"></i> Cetak Nota
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-transaksi">
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
