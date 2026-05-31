@php
    $sidebarPills = [
        ['lines' => ['Data', 'Barang'], 'route' => 'barang.index', 'active' => 'barang.*'],
        ['lines' => ['Kategori', 'Barang'], 'route' => 'kategori.index', 'active' => 'kategori.*'],
        ['lines' => ['Supplier'], 'route' => 'suplier.index', 'active' => 'suplier.*'],
    ];
@endphp

<aside class="yumna-sidebar">
    <nav class="sidebar-pills">
        @foreach ($sidebarPills as $pill)
            <a
                href="{{ route($pill['route']) }}"
                class="sidebar-pill {{ request()->routeIs($pill['active']) ? 'is-active' : '' }}"
            >
                <span class="pill-icon-side">
                    <svg class="pill-cube-icon" viewBox="0 0 56 56" aria-hidden="true">
                        <path d="M28 9 L46 20 L46 38 L28 49 L10 38 L10 20 Z" fill="#ffffff"/>
                        <path d="M28 9 L46 20 L28 31 L10 20 Z" fill="#ffffff" stroke="#7a6248" stroke-width="1.4" stroke-linejoin="round"/>
                        <path d="M10 20 L10 38 L28 49 L28 31 Z" fill="#f3eee8" stroke="#7a6248" stroke-width="1.4" stroke-linejoin="round"/>
                        <path d="M28 31 L46 20 L46 38 L28 49 Z" fill="#e8dfd4" stroke="#7a6248" stroke-width="1.4" stroke-linejoin="round"/>
                        <path d="M14 22 H42" stroke="#7a6248" stroke-width="2.2" stroke-linecap="round"/>
                        <path d="M28 31 V49" stroke="#7a6248" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </span>
                <span class="pill-label-side">
                    <span class="pill-text">
                        @foreach ($pill['lines'] as $line)
                            <span class="pill-line">{{ $line }}</span>
                        @endforeach
                    </span>
                </span>
            </a>
        @endforeach
    </nav>
    <button type="button" class="sidebar-toggle" aria-label="Sembunyikan panel">
        <i class="fa-solid fa-chevron-left"></i>
    </button>
</aside>
