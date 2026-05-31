@once
<style>
    :root {
        --yumna-topnav-h: 44px;
        --yumna-header-h: 96px;
        --yumna-chrome-h: calc(var(--yumna-topnav-h) + var(--yumna-header-h));
        --yumna-hero-gap: 14px;
        --yumna-hero-arch-r: 50% 50% 0 0 / 46% 46% 0 0;
        --yumna-hero-img-opacity: 0.94;
        --yumna-hero-overlay-opacity: 0.05;
    }

    html,
    body.page-yumna {
        width: 100%;
        height: 100%;
        overflow: hidden;
        background: #faf7f2;
    }

    .yumna-app {
        width: 100%;
        height: 100dvh;
        max-height: 100dvh;
        overflow: hidden;
        background: #faf7f2;
    }

    .yumna-frame {
        width: 100%;
        height: 100%;
        max-height: 100dvh;
        background: #faf7f2;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .yumna-frame > .top-nav,
    .yumna-frame > .main-header {
        flex-shrink: 0;
    }

    .yumna-main {
        flex: 1 1 auto;
        width: 100%;
        min-height: 0;
        background: #faf7f2;
        display: flex;
        flex-direction: column;
        padding-top: var(--yumna-hero-gap);
        overflow: hidden;
    }

    .yumna-hero-arch {
        flex: 1 1 auto;
        width: 100%;
        min-height: 0;
        max-height: 100%;
        overflow: hidden;
        border-radius: var(--yumna-hero-arch-r);
        background: #faf7f2;
        position: relative;
    }

    .yumna-hero-arch::after {
        content: '';
        position: absolute;
        inset: 0;
        background: #faf7f2;
        opacity: var(--yumna-hero-overlay-opacity);
        pointer-events: none;
        z-index: 1;
    }

    .yumna-hero-arch img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center center;
        display: block;
        opacity: var(--yumna-hero-img-opacity);
        filter: none;
    }

    .yumna-content {
        flex: 0 0 auto;
        width: 100%;
        min-height: 0;
        position: relative;
        background: #faf7f2;
        overflow: auto;
    }

    .yumna-content:not(:has(*)) {
        display: none;
    }

    /* Halaman dengan konten: izinkan scroll di area konten saja */
    body.page-yumna.page-scroll .yumna-app,
    body.page-yumna.page-scroll .yumna-frame {
        height: auto;
        max-height: none;
        min-height: 100dvh;
        overflow: visible;
    }

    body.page-yumna.page-scroll {
        overflow: auto;
    }

    body.page-yumna.page-scroll .yumna-main {
        overflow: visible;
        min-height: auto;
    }

    body.page-yumna.page-scroll .yumna-hero-arch {
        flex: 0 0 auto;
        height: clamp(220px, 32vh, 360px);
        max-height: none;
    }

    body.page-kategori,
    body.page-suplier,
    body.page-barang,
    body.page-stokbarang,
    body.page-transaksi,
    body.page-transaksi-pos {
        --yumna-header-h: 118px;
    }

    body.page-kategori .yumna-main,
    body.page-suplier .yumna-main,
    body.page-barang .yumna-main,
    body.page-stokbarang .yumna-main,
    body.page-transaksi .yumna-main,
    body.page-transaksi-pos .yumna-main {
        padding-top: var(--yumna-hero-gap);
    }

    body.page-kategori .yumna-content,
    body.page-suplier .yumna-content,
    body.page-barang .yumna-content,
    body.page-stokbarang .yumna-content,
    body.page-transaksi .yumna-content,
    body.page-transaksi-pos .yumna-content {
        flex: 1 1 auto;
        min-height: 0;
        height: 100%;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {
        :root {
            --yumna-header-h: 88px;
            --yumna-hero-gap: 10px;
            --yumna-hero-arch-r: 50% 50% 0 0 / 50% 50% 0 0;
        }
    }
</style>
@endonce
