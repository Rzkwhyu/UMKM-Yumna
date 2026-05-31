<header class="main-header @hasSection('header-toolbar') main-header--tall @endif">
    <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('image/lgoyumna.png') }}" alt="Logo Yumna">
        <h1>YUMNA</h1>
    </a>

    <div class="header-center">
        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Cari barang..." id="yumnaSearchInput">
        </div>

        @hasSection('header-toolbar')
            <div class="header-toolbar">
                @yield('header-toolbar')
            </div>
        @endif
    </div>

    <div class="header-right">
        <span class="greeting">Hi, {{ Auth::user()->name }}!</span>
        <img class="avatar" src="https://i.pravatar.cc/100?u={{ Auth::id() }}" alt="Profil">
        <a href="{{ route('transaksi.create') }}" class="cart-btn" title="Keranjang">
            <i class="fa-solid fa-cart-shopping"></i>
        </a>
    </div>
</header>
