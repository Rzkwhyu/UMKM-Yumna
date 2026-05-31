@once
<style>
    .yumna-sidebar {
        flex: 0 0 40%;
        width: 40%;
        max-width: 40%;
        align-self: stretch;
        margin-left: -36px;
        position: relative;
        background-image: url('{{ asset('image/bckgrndyumna.jpeg') }}');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 24px 16px 24px 40px;
        overflow: visible;
        z-index: 1;
        min-height: 0;
    }

    .yumna-sidebar::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.2);
        pointer-events: none;
    }

    .sidebar-pills {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 14px;
        width: 72%;
        max-width: 300px;
        min-width: 240px;
        overflow: visible;
    }

    .sidebar-pill {
        display: flex;
        align-items: stretch;
        min-height: 76px;
        text-decoration: none;
        border-radius: 24px;
        overflow: visible;
        filter: drop-shadow(0 3px 10px rgba(0, 0, 0, 0.18));
        transition: transform 0.15s ease;
    }

    .sidebar-pill:hover {
        transform: translateX(-4px);
    }

    /* Kiri — kayu coklat gelap (di atas lengkungan coklat muda) */
    .pill-icon-side {
        flex: 0 0 36%;
        min-width: 98px;
        background-image:
            linear-gradient(180deg, rgba(72, 52, 36, 0.55), rgba(58, 40, 28, 0.65)),
            url('{{ asset('image/bckgrnd1.png') }}');
        background-size: cover;
        background-position: center;
        border-radius: 24px 0 0 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 3;
        flex-shrink: 0;
        padding: 0 6px;
    }

    .pill-cube-icon {
        width: 40px;
        height: 40px;
        display: block;
        flex-shrink: 0;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    /* Kanan — kayu coklat muda (kayuputih.png) + lengkung kiri */
    .pill-label-side {
        flex: 1 1 auto;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: -22px;
        padding: 10px 24px 10px 32px;
        z-index: 2;
        min-height: 76px;
    }

    .pill-label-side::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: -4px;
        background-color: #e8dcc8;
        background-image: url('{{ asset('image/kayuputih.png') }}');
        background-size: cover;
        background-position: center;
        border-radius: 0 24px 24px 0;
        z-index: 0;
    }

    .pill-label-side::after {
        content: '';
        position: absolute;
        left: -24px;
        top: 50%;
        transform: translateY(-50%);
        width: 48px;
        height: 48px;
        background-color: #ebe0d0;
        background-image: url('{{ asset('image/kayuputih.png') }}');
        background-size: cover;
        background-position: left center;
        border-radius: 50%;
        z-index: -1;
    }

    .pill-text {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        line-height: 1.08;
    }

    .pill-line {
        display: block;
        font-size: 17px;
        font-weight: 800;
        color: #2f2418;
        letter-spacing: -0.02em;
    }

    .sidebar-pill.is-active .pill-label-side::before,
    .sidebar-pill.is-active .pill-label-side::after {
        filter: brightness(0.94);
    }

    .sidebar-pill.is-active .pill-icon-side {
        filter: brightness(1.05);
    }

    .sidebar-pill.is-active .pill-line {
        color: #1a1208;
    }

    .sidebar-toggle {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        z-index: 6;
        width: 26px;
        height: 52px;
        border: 1px solid #b0b5bd;
        border-right: none;
        border-radius: 10px 0 0 10px;
        background: #e4e7ec;
        color: #5f6673;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        padding: 0;
    }

    .sidebar-toggle:hover {
        background: #d8dde4;
    }

    @media (max-width: 1100px) {
        .yumna-sidebar {
            flex: none;
            width: 100%;
            max-width: 100%;
            margin-left: 0;
            min-height: 280px;
            padding: 32px 20px;
            justify-content: center;
        }

        .sidebar-pills {
            width: 85%;
            max-width: 320px;
        }

        .sidebar-toggle {
            display: none;
        }
    }
</style>
@endonce
