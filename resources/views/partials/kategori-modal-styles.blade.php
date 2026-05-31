@once
<style>
    .kategori-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 1000;
        background: rgba(0, 0, 0, 0.35);
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .kategori-modal-overlay.is-open {
        display: flex;
    }

    .kategori-modal {
        width: 100%;
        max-width: 520px;
        background: #ececec;
        border-radius: 28px;
        padding: 36px 32px 32px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
    }

    .kategori-modal--tall {
        max-height: 90vh;
        overflow-y: auto;
    }

    .kategori-modal-field input {
        width: 100%;
        border: none;
        background: transparent;
        outline: none;
        font-size: 15px;
        color: #374151;
        font-family: inherit;
    }

    .kategori-modal-field input::placeholder {
        color: #9ca3af;
    }

    .kategori-modal-field--row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .kategori-modal-field--row label {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        flex-shrink: 0;
    }

    .kategori-modal-field--row input {
        text-align: right;
        flex: 1;
    }

    .kategori-modal-field--row select {
        flex: 1;
        max-width: 220px;
        border: none;
        background: transparent;
        outline: none;
        font-size: 14px;
        color: #374151;
        font-family: inherit;
        cursor: pointer;
        text-align: right;
    }

    .kategori-modal-readonly {
        flex: 1;
        text-align: right;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .kategori-modal-field--file input[type="file"] {
        flex: 1;
        max-width: 220px;
        font-size: 12px;
        color: #6b7280;
        cursor: pointer;
    }

    .kategori-modal-field--file input[type="file"]::file-selector-button {
        margin-right: 10px;
        padding: 6px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
        color: #374151;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
    }

    .kategori-modal-divider {
        height: 1px;
        background: #d1d5db;
        margin: 28px 0;
    }

    .kategori-modal-error {
        display: block;
        margin-top: 8px;
        font-size: 12px;
        color: #b91c1c;
    }

    .kategori-modal-error--block {
        margin-top: -12px;
        margin-bottom: 8px;
    }

    .kategori-modal-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        margin-top: 36px;
    }

    .kategori-btn-simpan,
    .kategori-btn-hapus {
        width: 140px;
        padding: 11px 20px;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        font-family: inherit;
        transition: opacity 0.15s;
    }

    .kategori-btn-simpan {
        background: #5a6578;
    }

    .kategori-btn-hapus {
        background: #c97a7a;
    }

    .kategori-btn-simpan:hover,
    .kategori-btn-hapus:hover {
        opacity: 0.92;
    }

    .kategori-modal-logo-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .kategori-modal-logo-preview img {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #d1d5db;
        background: #fff;
    }

    .kategori-modal-logo-preview span {
        font-size: 12px;
        color: #6b7280;
    }
</style>
@endonce
