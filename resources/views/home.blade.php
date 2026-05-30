<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Yumna</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            min-height:100vh;
            background:#f5f1ea;
            overflow-x:hidden;
        }

        .navbar{
            width:100%;
            height:90px;

            background-image:url('/image/bckgrnd1.png');
            background-size:100% 100%;

            display:flex;
            justify-content:space-between;
            align-items:center;

            padding:0 50px;
        }

        .logo{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .logo img{
            width:50px;
        }

        .logo h1{
            font-size:32px;
        }

        .search-box input{
            width:500px;
            padding:12px;

            border:none;
            border-radius:10px;
        }

        .profile{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .profile img{
            width:50px;
            height:50px;

            border-radius:50%;
        }

        .dashboard-card{
            display:flex;
            justify-content:center;
            gap:15px;
            flex-wrap:nowrap;
            margin-top:30px;

            position:relative;
            z-index:2;
        }

        .card{
            width:250px;
            height:105px;

            display:flex;
            overflow:hidden;

            border-radius:20px;

            box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }

        .card h3{
            margin-bottom:10px;
        }

        .card h1{
            font-size:24px;
        }

        .status-box{
            width:450px;
            background:white;
            border-radius:20px;
            padding:20px;

            box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }
        .status-box h3{
            margin-bottom:20px;
        }

        .stok-item{
            margin-bottom:15px;
        }

        .stok-area{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .progress{
            flex:1;
            height:10px;

            background:#ddd;

            border-radius:10px;

            overflow:hidden;
        }

        .hijau{
            height:100%;
            background:green;
        }

        .kuning{
            height:100%;
            background:orange;
        }

        .merah{
            height:100%;
            background:red;
        }
        .bg-circle{
            width:900px;
            height:450px;

            background-image:url('/image/bckgrndyumna.jpeg');

            background-size:cover;
            background-position:center;

            border-radius:50% 50% 0 0;

            position:absolute;

            top:260px;
            left:50%;

            transform:translateX(-50%);

            opacity:0.35;

            z-index:0;
        }
        .transaksi-box{
            width:740px;

            background:white;

            border-radius:20px;

            padding:20px;

            box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }

            .transaksi-box table{
                width:100%;
                border-collapse:collapse;
        }

            .transaksi-box th{
                text-align:left;
                padding:10px;

                border-bottom:1px solid #ddd;
        }

            .transaksi-box td{
                padding:10px;

                border-bottom:1px solid #eee;
        }
            .content-row{
                display:flex;

                justify-content:center;

                align-items:flex-start;

                gap:30px;

                margin-top:30px;

                position:relative;

                z-index:2;
        }
        .grafik-box{
                width:740px;

                height:260px;

                background:white;
                border-radius:20px;
                padding:20px;

                position:relative;
                z-index:2;

                box-shadow:0 4px 10px rgba(0,0,0,0.15);
        }
        .main-content{
                width:95%;
                max-width:1400px;

                margin:30px auto;

                display:flex;
                gap:10px;

                align-items:flex-start;

                position:relative;
                z-index:2;
            }
        .left-side{
                flex:1;

                display:flex;
                flex-direction:column;

                gap:25px;
            }
        .chart{
                height:170px;

                display:flex;
                align-items:flex-end;

                gap:15px;

                padding:20px;
                margin-top:20px;
        }

        .bar{
            width:40px;

            background:#4d7df3;

            border-radius:8px 8px 0 0;

            position:relative;

            flex-shrink:0;
        }
        .bar span{
            position:absolute;

            bottom:-25px;
            left:50%;

            transform:translateX(-50%);

            font-size:12px;
        }
        .icon-side{
            width:70px;

            background-image:url('/image/bckgrnd2.png');
            background-size:cover;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:40px;
            color:white;
        }
        .icon-side{
            width:90px;

            background-image:url('/image/bckgrnd2.png');
            background-size:cover;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:42px;
        }
        .info-side h3{
            font-size:16px;
            margin-bottom:10px;
        }

        .info-side h1{
            font-size:22px;
        }
    </style>
</head>
<body>

    <div class="navbar">

        <div class="logo">
            <img src="/image/lgoyumna.png">
            <h1>YUMNA</h1>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Cari Barang...">
        </div>

        <div class="profile">
            <p>Hi, Admin</p>
            <img src="https://i.pravatar.cc/100">
        </div>

    </div>

    <div class="dashboard-card">

            <div class="card">

        <div class="icon-side">
            📦
        </div>

        <div class="info-side">
            <h3>Total Produk</h3>
            <h1>{{ $totalProduk }}</h1>
    </div>

    </div>

        <div class="card">

                <div class="icon-side">
                    ⚠️
                </div>

                <div class="info-side">
                    <h3>Barang Hampir Habis</h3>
                    <h1>{{ $barangHabis }}</h1>
                </div>

            </div>

        <div class="card">

    <div class="icon-side">
        🛒
    </div>

    <div class="info-side">
        <h3>Transaksi</h3>
        <h1>{{ $transaksiHariIni }}</h1>
    </div>

    </div>
       <div class="card">

    <div class="icon-side">
        💳
    </div>

    <div class="info-side">
        <h3>Total Penjualan</h3>
        <h1>Rp {{ number_format($totalPenjualan,0,',','.') }}</h1>
    </div>
        </div>
</div>

    <div class="main-content">

        <div class="left-side">

            <div class="grafik-box">

                <h3>Grafik Penjualan Mingguan</h3>

                <div class="chart">

                    <div class="bar" style="height:70px;"><span>Sen</span></div>
                    <div class="bar" style="height:120px;"><span>Sel</span></div>
                    <div class="bar" style="height:50px;"><span>Rab</span></div>
                    <div class="bar" style="height:160px;"><span>Kam</span></div>
                    <div class="bar" style="height:80px;"><span>Jum</span></div>
                    <div class="bar" style="height:160px;"><span>Sab</span></div>
                    <div class="bar" style="height:160px;"><span>Min</span></div>

                </div>

            </div>

            <div class="transaksi-box">

                <h3>Transaksi Terakhir</h3>

                <table>

                    <tr>
                        <th>No</th>
                        <th>Pembeli</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>

                    @foreach($transaksiTerakhir as $trx)

                    <tr>
                        <td>#{{ $trx->id }}</td>
                        <td>{{ $trx->nama_pembeli }}</td>
                        <td>{{ $trx->qty }}</td>
                        <td>Rp {{ number_format($trx->total_harga,0,',','.') }}</td>
                    </tr>

                    @endforeach

                </table>

            </div>

        </div>

        <div class="status-box">

            <h3>Status Stok Barang</h3>

            @foreach($statusBarang as $barang)

            <div class="stok-item">

                <span>{{ $barang->nama_barang }}</span>

                <div class="stok-area">

                    <div class="progress">

                        <div
                        class="
                        @if($barang->stok > 20)
                            hijau
                        @elseif($barang->stok >= 10)
                            kuning
                        @else
                            merah
                        @endif
                        "
                        style="width:{{ min($barang->stok,100) }}%">
                        </div>

                    </div>

                    <span>{{ $barang->stok }}</span>

                </div>

            </div>

            @endforeach

        </div>

    </div>

    <div class="bg-circle"></div>

</body>
</html>