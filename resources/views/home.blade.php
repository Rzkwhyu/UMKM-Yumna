<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Yumna</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', Arial, Helvetica, sans-serif;
            background: #f0ebe3;
            color: #1a1a1a;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Wood header */
        .main-header {
            height: 96px;
            background-image: url('{{ asset('image/bckgrnd1.png') }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            gap: 24px;
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

        .search-wrap {
            flex: 1;
            max-width: 520px;
            position: relative;
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

        /* Page with blurred store background */
        .page-body {
            position: relative;
            padding: 28px 40px 48px;
            min-height: calc(100vh - 140px);
        }

        .page-body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url('{{ asset('image/bckgrndyumna.jpeg') }}');
            background-size: cover;
            background-position: center;
            filter: blur(6px);
            opacity: 0.45;
            z-index: 0;
        }

        .page-inner {
            position: relative;
            z-index: 1;
            max-width: 1320px;
            margin: 0 auto;
        }

        /* Stat cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #ebe0d0;
            border-radius: 18px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(145deg, #c4a574, #a88452);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 700;
            line-height: 1.1;
        }

        /* Main grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 22px;
            align-items: stretch;
        }

        .left-col {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .panel {
            background: #fff;
            border-radius: 18px;
            padding: 22px 24px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        /* Chart */
        .chart-area {
            height: 200px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 8px;
            padding: 12px 8px 32px;
            margin-top: 8px;
        }

        .chart-bar-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
            justify-content: flex-end;
        }

        .chart-bar {
            width: 100%;
            max-width: 44px;
            border-radius: 8px 8px 0 0;
            min-height: 8px;
            transition: height 0.3s;
        }

        .chart-bar.light {
            background: #b8d4f5;
        }

        .chart-bar.dark {
            background: #3b7ddd;
        }

        .chart-day {
            margin-top: 10px;
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
        }

        /* Transactions */
        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .panel-header h3 {
            font-size: 17px;
            font-weight: 700;
        }

        .link-all {
            color: #3b7ddd;
            font-size: 13px;
            font-weight: 600;
        }

        .link-all:hover {
            text-decoration: underline;
        }

        .trx-table {
            width: 100%;
            border-collapse: collapse;
        }

        .trx-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 10px 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .trx-table td {
            padding: 14px 12px;
            font-size: 13px;
            border-bottom: 1px solid #f5f5f5;
            color: #374151;
        }

        .trx-table tr:last-child td {
            border-bottom: none;
        }

        .trx-id {
            font-weight: 600;
            color: #1f2937;
        }

        .badge-selesai {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #16a34a;
        }

        .badge-selesai::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
        }

        .empty-row td {
            text-align: center;
            color: #9ca3af;
            padding: 24px;
        }

        /* Stock panel */
        .stock-panel {
            height: 100%;
        }

        .stock-panel h3 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .stock-item {
            margin-bottom: 16px;
        }

        .stock-item:last-child {
            margin-bottom: 0;
        }

        .stock-name {
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
            color: #374151;
        }

        .stock-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stock-bar {
            flex: 1;
            height: 8px;
            background: #e5e7eb;
            border-radius: 999px;
            overflow: hidden;
        }

        .stock-fill {
            height: 100%;
            border-radius: 999px;
        }

        .stock-fill.hijau { background: #22c55e; }
        .stock-fill.oranye { background: #f59e0b; }
        .stock-fill.kosong { background: transparent; }

        .stock-qty {
            font-size: 13px;
            font-weight: 600;
            min-width: 28px;
            text-align: right;
            color: #374151;
        }

        .stock-qty.nol {
            color: #ef4444;
        }

        @media (max-width: 1100px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-header {
                flex-wrap: wrap;
                height: auto;
                padding: 16px 20px;
            }

            .search-wrap {
                order: 3;
                max-width: 100%;
                width: 100%;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .page-body {
                padding: 20px 16px 32px;
            }

        }
    </style>
</head>
<body>

    @include('partials.yumna-top-nav')

    <header class="main-header">
        <div class="logo">
            <img src="{{ asset('image/lgoyumna.png') }}" alt="Logo Yumna">
            <h1>YUMNA</h1>
        </div>

        <div class="search-wrap">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Cari barang...">
        </div>

        <div class="header-right">
            <span class="greeting">Hi, {{ Auth::user()->name }}!</span>
            <img class="avatar" src="https://i.pravatar.cc/100?u={{ Auth::id() }}" alt="Profil">
            <a href="{{ route('transaksi.create') }}" class="cart-btn" title="Keranjang">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </header>

    <div class="page-body">
        <div class="page-inner">

            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-box"></i></div>
                    <div>
                        <div class="stat-label">Total Produk</div>
                        <div class="stat-value">{{ $totalProduk }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                    <div>
                        <div class="stat-label">Barang Hampir Habis</div>
                        <div class="stat-value">{{ $barangHabis }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                    <div>
                        <div class="stat-label">Transaksi</div>
                        <div class="stat-value">{{ $transaksiHariIni }}</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
                    <div>
                        <div class="stat-label">Total Penjualan</div>
                        <div class="stat-value">
                            @if($totalPenjualan >= 1_000_000)
                                {{ $penjualanFormatted }}
                            @else
                                Rp {{ $penjualanFormatted }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <div class="left-col">
                    <div class="panel">
                        <div class="chart-area">
                            @foreach($hariLabels as $index => $hari)
                                @php
                                    $nilai = $penjualanMingguan[$index];
                                    $tinggi = $nilai > 0
                                        ? max(12, round(($nilai / $maxPenjualanMingguan) * 140))
                                        : 12;
                                    $isDark = $nilai >= ($maxPenjualanMingguan * 0.55);
                                @endphp
                                <div class="chart-bar-wrap">
                                    <div
                                        class="chart-bar {{ $isDark ? 'dark' : 'light' }}"
                                        style="height: {{ $tinggi }}px;"
                                        title="Rp {{ number_format($nilai, 0, ',', '.') }}"
                                    ></div>
                                    <span class="chart-day">{{ $hari }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3>Transaksi Terakhir</h3>
                            <a href="{{ route('transaksi.index') }}" class="link-all">Lihat Semua &rarr;</a>
                        </div>

                        <table class="trx-table">
                            <thead>
                                <tr>
                                    <th>No. Trx</th>
                                    <th>Tanggal</th>
                                    <th>Kasir</th>
                                    <th>Item</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksiTerakhir as $trx)
                                <tr>
                                    <td class="trx-id">#{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $trx->created_at->format('d') }} {{ ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'][$trx->created_at->month - 1] }} {{ $trx->created_at->format('Y, H:i') }}</td>
                                    <td>{{ Auth::user()->name }}</td>
                                    <td>{{ $trx->qty }}</td>
                                    <td>Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                    <td><span class="badge-selesai">Selesai</span></td>
                                </tr>
                                @empty
                                <tr class="empty-row">
                                    <td colspan="6">Belum ada transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel stock-panel">
                    <h3>Status Stok Barang</h3>

                    @foreach($statusBarang as $barang)
                        @php
                            $stok = (int) $barang->stok;
                            $lebar = $stok > 0 ? min(100, round(($stok / $maxStok) * 100)) : 0;

                            if ($stok === 0) {
                                $kelas = 'kosong';
                                $qtyClass = 'nol';
                            } elseif ($stok <= 20) {
                                $kelas = 'oranye';
                                $qtyClass = '';
                            } else {
                                $kelas = 'hijau';
                                $qtyClass = '';
                            }
                        @endphp
                        <div class="stock-item">
                            <div class="stock-name">{{ $barang->nama_barang }}</div>
                            <div class="stock-row">
                                <div class="stock-bar">
                                    @if($stok > 0)
                                        <div class="stock-fill {{ $kelas }}" style="width: {{ $lebar }}%;"></div>
                                    @endif
                                </div>
                                <span class="stock-qty {{ $qtyClass }}">{{ $stok }}</span>
                            </div>
                        </div>
                    @endforeach

                    @if($statusBarang->isEmpty())
                        <p style="color:#9ca3af;font-size:13px;">Belum ada data barang.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

</body>
</html>
