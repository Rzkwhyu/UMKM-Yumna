@php
    $primaryNav = [
        ['label' => 'Home', 'route' => 'home', 'active' => 'home'],
        ['label' => 'Transaksi', 'route' => 'transaksi.index', 'active' => 'transaksi.*'],
        ['label' => 'Stok Barang', 'route' => 'stokbarang.index', 'active' => 'stokbarang.*'],
        ['label' => 'Laporan Keuangan', 'route' => 'laporan.index', 'active' => 'laporan.*'],
    ];

    $moreNav = [
        ['label' => 'Kategori', 'route' => 'kategori.index', 'active' => 'kategori.*'],
        ['label' => 'Barang', 'route' => 'barang.index', 'active' => 'barang.*'],
        ['label' => 'Suplier', 'route' => 'suplier.index', 'active' => 'suplier.*'],
    ];

    $moreMenuActive = collect($moreNav)->contains(
        fn ($item) => request()->routeIs($item['active'])
    );
@endphp

@once
<style>
    .top-nav {
        height: 44px;
        width: 100%;
        background: #4a3728;
        display: flex;
        align-items: center;
        padding: 0 28px;
        gap: 28px;
        position: relative;
        z-index: 200;
    }

    .top-nav-start {
        position: relative;
        display: flex;
        align-items: center;
    }

    .top-nav .menu-btn {
        background: none;
        border: none;
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        padding: 6px 8px;
        line-height: 1;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .top-nav .menu-btn:hover,
    .top-nav .menu-btn.is-open {
        background: rgba(255, 255, 255, 0.12);
    }

    .top-nav .menu-btn.has-active {
        color: #93c5fd;
    }

    .burger-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        min-width: 200px;
        background: #2f2f2f;
        border-radius: 10px;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.35);
        padding: 8px 0;
        list-style: none;
    }

    .burger-dropdown.is-open {
        display: block;
    }

    .burger-dropdown a {
        display: block;
        padding: 11px 20px;
        color: #f5f5f5;
        font-size: 14px;
        font-weight: 500;
        transition: background 0.15s;
    }

    .burger-dropdown a:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .burger-dropdown a.active {
        background: rgba(59, 125, 221, 0.25);
        color: #93c5fd;
    }

    .top-nav-links {
        display: flex;
        align-items: center;
        gap: 28px;
        list-style: none;
    }

    .top-nav-links a {
        color: #f5f5f5;
        font-size: 14px;
        font-weight: 500;
    }

    .top-nav-links a:hover,
    .top-nav-links a.active {
        text-decoration: underline;
        text-underline-offset: 4px;
    }
</style>
@endonce

<nav class="top-nav">
    <div class="top-nav-start">
        <button
            type="button"
            class="menu-btn {{ $moreMenuActive ? 'has-active' : '' }}"
            id="yumnaBurgerBtn"
            aria-label="Menu lainnya"
            aria-expanded="false"
            aria-controls="yumnaBurgerMenu"
        >
            <i class="fa-solid fa-bars"></i>
        </button>

        <ul class="burger-dropdown" id="yumnaBurgerMenu" role="menu">
            @foreach ($moreNav as $item)
                <li role="none">
                    <a
                        role="menuitem"
                        href="{{ route($item['route']) }}"
                        class="{{ request()->routeIs($item['active']) ? 'active' : '' }}"
                    >{{ $item['label'] }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <ul class="top-nav-links">
        @foreach ($primaryNav as $item)
            <li>
                <a
                    href="{{ isset($item['url']) ? $item['url'] : route($item['route']) }}"
                    class="{{ request()->routeIs($item['active']) ? 'active' : '' }}"
                >{{ $item['label'] }}</a>
            </li>
        @endforeach
    </ul>
</nav>

@once
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('yumnaBurgerBtn');
        const menu = document.getElementById('yumnaBurgerMenu');

        if (!btn || !menu) {
            return;
        }

        function closeMenu() {
            menu.classList.remove('is-open');
            btn.classList.remove('is-open');
            btn.setAttribute('aria-expanded', 'false');
        }

        function openMenu() {
            menu.classList.add('is-open');
            btn.classList.add('is-open');
            btn.setAttribute('aria-expanded', 'true');
        }

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (menu.classList.contains('is-open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        menu.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        document.addEventListener('click', closeMenu);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeMenu();
            }
        });
    });
</script>
@endonce
