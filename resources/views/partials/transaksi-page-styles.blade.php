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
        table-layout: fixed;
        min-width: 940px;
    }

    .trx-table th:nth-child(1),
    .trx-table td:nth-child(1) {
        width: 195px;
        min-width: 195px;
    }

    .trx-table th:nth-child(2),
    .trx-table td:nth-child(2) {
        width: 172px;
        min-width: 172px;
    }

    .trx-table th:nth-child(3),
    .trx-table td:nth-child(3) {
        width: 430px;
    }

    .trx-table th:nth-child(4),
    .trx-table td:nth-child(4) {
        width: 140px;
    }

    .trx-table th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #faf7f2;
        text-align: center;
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
        white-space: nowrap;
    }

    .trx-table td:nth-child(2) {
        white-space: nowrap;
    }

    .trx-table td:nth-child(4) {
        text-align: center;
    }

    .trx-detail-cell {
        padding: 10px 12px;
        vertical-align: top;
    }

    .trx-item-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        background: #fff;
        border: 1px solid #ece7df;
        border-radius: 12px;
        overflow: hidden;
    }

    .trx-item-table thead th {
        position: static;
        background: #f9fafb;
        text-transform: none;
        letter-spacing: 0;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        padding: 8px 10px;
        border-bottom: 1px solid #ece7df;
    }

    .trx-item-table thead th:nth-child(1),
    .trx-item-table tbody td:nth-child(1),
    .trx-item-table tfoot td.trx-foot-meta {
        text-align: left;
        width: 38%;
    }

    .trx-item-table thead th:nth-child(2),
    .trx-item-table tbody td:nth-child(2),
    .trx-item-table tfoot td:nth-child(2) {
        text-align: right;
        width: 22%;
        white-space: nowrap;
    }

    .trx-item-table thead th:nth-child(3),
    .trx-item-table tbody td:nth-child(3),
    .trx-item-table tfoot td.trx-total-label {
        text-align: right;
        width: 12%;
        white-space: nowrap;
    }

    .trx-item-table thead th:nth-child(4),
    .trx-item-table tbody td:nth-child(4),
    .trx-item-table tfoot td.trx-total-akumulasi {
        text-align: right;
        width: 28%;
        white-space: nowrap;
    }

    .trx-item-table tbody td {
        padding: 9px 10px;
        font-size: 13px;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
    }

    .trx-item-table tbody tr:last-child td {
        border-bottom: none;
    }

    .trx-item-table tfoot td {
        padding: 10px;
        background: #faf7f2;
        border-top: 1px solid #ece7df;
        font-size: 13px;
        vertical-align: middle;
    }

    .trx-foot-meta {
        text-align: left !important;
    }

    .trx-qty-total {
        margin-left: 8px;
        font-size: 12px;
        color: #6b7280;
    }

    .trx-total-label {
        font-weight: 700;
        color: #1f2937;
    }

    .trx-count-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: 12px;
        font-weight: 600;
    }

    .trx-total-akumulasi {
        font-weight: 800;
        color: #1f2937;
    }

    .trx-actions {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-cetak-nota {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        color: #fff;
        background: #6b7280;
        transition: opacity 0.15s;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-cetak-nota:hover {
        opacity: 0.9;
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
