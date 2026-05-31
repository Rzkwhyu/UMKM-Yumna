@once
<style>
    .transaksi-page {
        flex: 1 1 auto;
        min-height: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        padding: 0 24px 24px;
    }

    .transaksi-panel {
        flex: 1 1 auto;
        min-height: 0;
        background: #fff;
        border: 2px solid #1a1a1a;
        border-radius: 0 100px 100px 0;
        padding: 28px 40px 32px 32px;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.06);
    }

    .transaksi-panel-head {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 22px;
        flex-shrink: 0;
    }

    .transaksi-panel-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #ebe4d4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #5c4a32;
        font-size: 20px;
        flex-shrink: 0;
    }

    .transaksi-panel-head h2 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 4px;
        color: #1a1a1a;
    }

    .transaksi-panel-head p {
        font-size: 13px;
        color: #6b7280;
    }

    .transaksi-panel-head .panel-meta {
        margin-left: auto;
        text-align: right;
        font-size: 13px;
        color: #6b7280;
    }

    .transaksi-panel-head .panel-meta strong {
        display: block;
        font-size: 22px;
        font-weight: 800;
        color: #1f2937;
        line-height: 1.2;
    }

    .alert-success,
    .alert-error {
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 16px;
        flex-shrink: 0;
    }

    .alert-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .transaksi-table-wrap {
        flex: 1;
        min-height: 0;
        overflow: auto;
        border: 1px solid #ece7df;
        border-radius: 16px;
    }

    .transaksi-table-wrap::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .transaksi-table-wrap::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 999px;
    }

    .trx-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 980px;
    }

    .trx-table th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #faf7f2;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 12px 14px;
        border-bottom: 1px solid #ece7df;
    }

    .trx-table td {
        padding: 14px;
        font-size: 13px;
        border-bottom: 1px solid #f5f5f5;
        color: #374151;
        vertical-align: middle;
    }

    .trx-table tbody tr:hover {
        background: #fcfaf7;
    }

    .trx-table tbody tr.is-hidden {
        display: none;
    }

    .trx-id {
        font-weight: 700;
        color: #1f2937;
    }

    .badge-selesai {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #16a34a;
    }

    .badge-selesai::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #22c55e;
    }

    .trx-actions {
        display: flex;
        gap: 8px;
    }

    .btn-edit,
    .btn-hapus {
        padding: 8px 20px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        color: #fff;
        transition: opacity 0.15s;
        font-family: inherit;
    }

    .btn-edit {
        background: #9ca3af;
    }

    .btn-hapus {
        background: #8b3a3a;
    }

    .btn-edit:hover,
    .btn-hapus:hover {
        opacity: 0.9;
    }

    .trx-form-delete {
        display: inline;
    }

    .empty-transaksi {
        text-align: center;
        color: #9ca3af;
        padding: 40px 16px;
        font-size: 14px;
        line-height: 1.6;
    }

    @media (max-width: 900px) {
        .transaksi-page {
            padding: 0 12px 16px;
        }

        .transaksi-panel {
            border-radius: 0 48px 48px 0;
            padding: 20px 16px;
        }

        .transaksi-panel-head {
            flex-wrap: wrap;
        }

        .transaksi-panel-head .panel-meta {
            width: 100%;
            margin-left: 0;
            text-align: left;
            margin-top: 8px;
        }
    }
</style>
@endonce
