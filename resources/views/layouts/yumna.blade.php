<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Yumna')</title>
    @include('partials.yumna-assets')
    @include('partials.yumna-header-styles')
    @include('partials.yumna-shell-styles')
    @stack('styles')
</head>
@php
    $bodyClass = trim($__env->yieldContent('body-class') ?: 'page-yumna');
    $hideHero = str_contains($bodyClass, 'page-kategori')
        || str_contains($bodyClass, 'page-suplier')
        || str_contains($bodyClass, 'page-barang')
        || str_contains($bodyClass, 'page-transaksi')
        || str_contains($bodyClass, 'page-transaksi-pos')
        || str_contains($bodyClass, 'page-data')
        || trim($__env->yieldContent('hide-hero')) !== '';
@endphp
<body class="{{ $bodyClass }}">
    <div class="yumna-app">
        <div class="yumna-frame">
            @include('partials.yumna-top-nav')
            @include('partials.yumna-main-header')

            <main class="yumna-main">
                @unless($hideHero)
                    <div class="yumna-hero-arch">
                        <img src="{{ asset('image/bckgrndyumna.jpeg') }}" alt="">
                    </div>
                @endunless

                <div class="yumna-content">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
