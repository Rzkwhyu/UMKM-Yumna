@once
<style>
    body.page-profile,
    body.page-profile-edit,
    body.page-profile-password {
        overflow: auto;
        background: #e8e4de;
    }

    body.page-profile .yumna-app,
    body.page-profile-edit .yumna-app,
    body.page-profile-password .yumna-app,
    body.page-profile .yumna-frame,
    body.page-profile-edit .yumna-frame,
    body.page-profile-password .yumna-frame {
        height: auto;
        max-height: none;
        min-height: 100dvh;
        overflow: visible;
        background: #e8e4de;
    }

    body.page-profile .yumna-main,
    body.page-profile-edit .yumna-main,
    body.page-profile-password .yumna-main {
        overflow: visible;
        padding-top: 0;
        background: #e8e4de;
    }

    body.page-profile .yumna-content,
    body.page-profile-edit .yumna-content,
    body.page-profile-password .yumna-content {
        flex: 1 1 auto;
        background: #e8e4de;
        overflow: visible;
        display: flex;
        justify-content: center;
        padding: 28px 20px 48px;
    }

    .profile-shell {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        min-height: 520px;
        display: flex;
        flex-direction: column;
    }

    .profile-topbar {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 22px 16px;
        border-bottom: 1px solid #f0f0f0;
    }

    .profile-back {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1a1a1a;
        font-size: 18px;
        border-radius: 8px;
        transition: background 0.15s;
    }

    .profile-back:hover {
        background: #f3f4f6;
    }

    .profile-topbar h2 {
        flex: 1;
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
    }

    .profile-topbar-action {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4a3728;
        font-size: 18px;
        border: none;
        background: none;
        cursor: pointer;
        border-radius: 8px;
    }

    .profile-topbar-action:hover {
        background: #f3f4f6;
    }

    .profile-body {
        flex: 1;
        padding: 22px;
    }

    .profile-user-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
    }

    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid #f3f4f6;
    }

    .profile-username {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
    }

    .profile-name {
        font-size: 15px;
        color: #6b7280;
    }

    .profile-section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 14px;
    }

    .profile-menu {
        list-style: none;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .profile-menu a,
    .profile-menu button {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 14px 16px;
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        font-family: inherit;
        text-align: left;
        transition: border-color 0.15s, background 0.15s;
    }

    .profile-menu a:hover,
    .profile-menu button:hover {
        border-color: #d1d5db;
        background: #fafafa;
    }

    .profile-menu i {
        color: #9ca3af;
        font-size: 14px;
    }

    .profile-menu .menu-logout {
        color: #374151;
    }

    .profile-photo-edit {
        text-align: center;
        margin-bottom: 24px;
    }

    .profile-photo-edit img {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        border: 2px solid #f0f0f0;
    }

    .profile-change-photo {
        font-size: 13px;
        color: #6b7280;
        cursor: pointer;
        display: inline-block;
    }

    .profile-change-photo:hover {
        color: #4a3728;
    }

    .profile-change-photo input {
        display: none;
    }

    .profile-form-group {
        margin-bottom: 16px;
    }

    .profile-form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
    }

    .profile-form-group input,
    .profile-form-group textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        color: #1f2937;
        background: #fff;
        outline: none;
        transition: border-color 0.15s;
    }

    .profile-form-group input:focus,
    .profile-form-group textarea:focus {
        border-color: #4a3728;
    }

    .profile-form-group textarea {
        min-height: 88px;
        resize: vertical;
    }

    .profile-form-error {
        font-size: 12px;
        color: #b91c1c;
        margin-top: 4px;
    }

    .profile-alert-success {
        margin: 0 22px 12px;
        padding: 10px 14px;
        background: #ecfdf5;
        color: #047857;
        border-radius: 10px;
        font-size: 13px;
        border: 1px solid #a7f3d0;
    }

    .btn-profile-primary {
        display: block;
        width: 100%;
        padding: 14px;
        margin-top: 8px;
        background: #4a3728;
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.2s;
    }

    .btn-profile-primary:hover {
        background: #3d2e22;
    }

    .profile-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 500;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .profile-modal-overlay.is-open {
        display: flex;
    }

    .profile-modal {
        background: #fff;
        border-radius: 16px;
        padding: 28px 24px 22px;
        max-width: 320px;
        width: 100%;
        text-align: center;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
    }

    .profile-modal p {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 22px;
        line-height: 1.4;
    }

    .profile-modal-actions {
        display: flex;
        gap: 12px;
    }

    .profile-modal-actions .btn-profile-primary,
    .profile-modal-actions .btn-profile-secondary {
        flex: 1;
        margin-top: 0;
        padding: 12px;
        border-radius: 12px;
        font-size: 14px;
    }

    .btn-profile-secondary {
        display: block;
        width: 100%;
        padding: 14px;
        background: #4a3728;
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
    }

    .btn-profile-secondary:hover {
        background: #3d2e22;
    }
</style>
@endonce
