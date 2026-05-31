@once
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        font-family: 'Inter', Arial, Helvetica, sans-serif;
        color: #1a1a1a;
        overflow-x: hidden;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    .main-header {
        width: 100%;
        background-image: url('{{ asset('image/bckgrnd1.png') }}');
        background-size: 100% 100%;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 40px;
        gap: 24px;
    }

    .main-header--tall {
        display: grid;
        grid-template-columns: auto minmax(320px, 520px) auto;
        align-items: center;
        column-gap: 32px;
        padding: 14px 36px;
        min-height: 118px;
    }

    .main-header--tall .logo {
        align-self: center;
    }

    .main-header--tall .header-center {
        max-width: none;
        width: 100%;
        justify-self: center;
        align-self: center;
    }

    .main-header--tall .header-right {
        align-self: center;
    }

    .main-header--tall .greeting {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .logo img {
        width: 48px;
        height: auto;
    }

    .logo h1 {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .header-center {
        flex: 1;
        max-width: 560px;
        margin: 0 auto;
    }

    .search-wrap {
        position: relative;
        width: 100%;
    }

    .search-wrap i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
    }

    .search-wrap input {
        width: 100%;
        padding: 12px 16px 12px 42px;
        border: none;
        border-radius: 999px;
        font-size: 14px;
        background: #fff;
        outline: none;
    }

    .search-wrap input::placeholder {
        color: #9ca3af;
    }

    .header-toolbar {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
        width: 100%;
    }

    .filter-select {
        padding: 8px 34px 8px 18px;
        border: none;
        border-radius: 999px;
        background: #d9d4ce;
        min-width: 168px;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border-radius: 999px;
        background: #fff;
        border: 1px solid #d1d5db;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        transition: background 0.15s;
        cursor: pointer;
        font-family: inherit;
    }

    .btn-tambah:hover {
        background: #f9fafb;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-shrink: 0;
    }

    .greeting {
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
    }

    .avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.8);
    }

    .cart-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        color: #6b7280;
        font-size: 18px;
        transition: transform 0.15s;
    }

    .cart-btn:hover {
        transform: scale(1.05);
    }
</style>
@endonce
