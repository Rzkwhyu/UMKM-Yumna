@extends('layouts.yumna')

@section('title', 'Riwayat Transaksi — Yumna')

@section('hide-hero')
@endsection

@push('styles')
<style>
    .transaksi-page {
        padding: 24px 40px 48px;
        max-width: 1320px;
        margin: 0 auto;
    }

    .transaksi-page .flash {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 18px;
    }

    .transaksi-page .flash--success {
        background: #dcfce7;
        color: #166534;
    }

    .transaksi-page .flash--error {
        background: #fee2e2;
        color: #991b1b;
    }

    .transaksi-page .panel {
        background: #fff;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    }

    .transaksi-page .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .transaksi-page .panel-header h1 {
        font-size: 20px;
        font-weight: 700;
    }

    .transaksi-page .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        background: linear-gradient(145deg, #c4a574, #a88452);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        transition: transform 0.15s, box-shadow 0.15s;
    }

    .transaksi-page .btn-tambah:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(168, 132, 82, 0.35);
    }

    .transaksi-page .trx-table-wrap {
        overflow-x: auto;
    }

    .transaksi-page .trx-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 720px;
    }

    .transaksi-page .trx-table th {
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 10px 12px;
        border-bottom: 1px solid #f0f0f0;
    }

    .transaksi-page .trx-table td {
        padding: 14px 12px;
        font-size: 13px;
        border-bottom: 1px solid #f5f5f5;
        color: #374151;
        vertical-align: middle;
    }

    .transaksi-page .trx-table tr:last-child td {
        border-bottom: none;
    }

    .transaksi-page .trx-id {
        font-weight: 600;
        color: #1f2937;
    }

    .transaksi-page .badge-selesai {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #16a34a;
    }

    .transaksi-page .badge-selesai::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #22c55e;
    }

    .transaksi-page .empty-row td {
        text-align: center;
        color: #9ca3af;
        padding: 32px 12px;
    }

    .transaksi-page .aksi {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .transaksi-page .aksi a,
    .transaksi-page .aksi button {
        font-size: 12px;
        font-weight: 600;
        border: none;
        background: none;
        cursor: pointer;
        padding: 0;
    }

    .transaksi-page .aksi-edit {
        color: #3b7ddd;
    }

    .transaksi-page .aksi-edit:hover {
        text-decoration: underline;
    }

    .transaksi-page .aksi-hapus {
        color: #dc2626;
    }

    .transaksi-page .aksi-hapus:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .transaksi-page {
            padding: 16px 20px 32px;
        }
    }
</style>
@endpush

@section('content')
@php
    $bulanSingkat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
@endphp

<div class="transaksi-page">
    @if(session('success'))
        <div class="flash flash--success" role="alert">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="flash flash--error" role="alert">{{ session('error') }}</div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <h1>Riwayat Transaksi</h1>
            <a href="{{ route('transaksi.create') }}" class="btn-tambah">
                <i class="fa-solid fa-plus"></i>
                Tambah Transaksi
            </a>
        </div>

        <div class="trx-table-wrap">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>No. Trx</th>
                        <th>Tanggal</th>
                        <th>Pembeli</th>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $trx)
                        <tr>
                            <td class="trx-id">#{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</td>
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
                                <div class="aksi">
                                    <a href="{{ route('transaksi.edit', $trx->id) }}" class="aksi-edit">Edit</a>
                                    <form
                                        action="{{ route('transaksi.destroy', $trx->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus transaksi ini?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="aksi-hapus">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="8">Belum ada riwayat transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
