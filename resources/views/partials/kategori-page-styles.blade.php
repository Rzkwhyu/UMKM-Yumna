@once
<style>
    .kategori-split {
        display: flex;
        flex: 1 1 auto;
        align-items: stretch;
        min-height: 0;
        height: 100%;
        width: 100%;
        overflow: visible;
    }

    .kategori-panel {
        flex: 0 0 60%;
        width: 60%;
        max-width: 60%;
        min-width: 0;
        background: #fff;
        border: 2px solid #1a1a1a;
        border-right: none;
        border-radius: 0 100px 100px 0;
        padding: 28px 40px 32px 32px;
        position: relative;
        z-index: 5;
        display: flex;
        flex-direction: column;
        min-height: 0;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.06);
    }

    .kategori-panel-head {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 22px;
        flex-shrink: 0;
    }

    .kategori-panel-icon {
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

    .kategori-panel-head h2 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 4px;
        color: #1a1a1a;
    }

    .kategori-panel-head p {
        font-size: 13px;
        color: #6b7280;
    }

    .alert-success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 16px;
        flex-shrink: 0;
    }

    .alert-error {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 16px;
        flex-shrink: 0;
    }

    .alert-error p {
        margin: 0;
    }

    .alert-error p + p {
        margin-top: 4px;
    }

    .kategori-list {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding-right: 8px;
    }

    .kategori-list::-webkit-scrollbar {
        width: 6px;
    }

    .kategori-list::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 999px;
    }

    .kategori-row {
        display: flex;
        align-items: center;
        gap: 14px;
        background: #fff;
        border: 1px solid #e8e4de;
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.15s;
    }

    .kategori-row:hover {
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }

    .kategori-row.is-hidden {
        display: none;
    }

    .kat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #4b5563;
        flex-shrink: 0;
        overflow: hidden;
    }

    .kat-logo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .kat-info {
        flex: 1;
        min-width: 0;
    }

    .kat-info h3 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 2px;
        color: #1f2937;
    }

    .kat-info span {
        font-size: 12px;
        color: #6b7280;
    }

    .kat-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
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

    .kat-form-delete {
        display: inline;
    }

    .empty-kategori {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #9ca3af;
        font-size: 14px;
        line-height: 1.6;
        padding: 24px;
    }

    @media (max-width: 1100px) {
        .kategori-split {
            flex-direction: column;
            overflow-y: auto;
        }

        .kategori-panel {
            flex: none;
            width: 100%;
            max-width: 100%;
            border-right: 2px solid #1a1a1a;
            border-radius: 0 0 48px 48px;
        }

        .kategori-list {
            max-height: none;
            overflow: visible;
        }
    }

    @media (max-width: 640px) {
        .kategori-panel {
            padding: 20px 16px;
        }

        .kategori-row {
            flex-wrap: wrap;
        }

        .kat-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>
@endonce
