<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Suplier;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    $totalProduk = Barang::count();

    $barangHabis = Barang::where('stok','<=',20)->count();

    $transaksiHariIni = Transaksi::whereDate(
        'created_at',
        now()->toDateString()
    )->count();

    $totalPenjualan = Transaksi::whereDate(
        'created_at',
        now()->toDateString()
    )->sum('total_harga');

    $statusBarang = Barang::all();
    $transaksiTerakhir = Transaksi::latest()->take(5)->get();
    $grafik = Transaksi::select(
    DB::raw('DATE(created_at) as tanggal'),
    DB::raw('SUM(total_harga) as total')
    )
    ->whereBetween('created_at', [
        now()->startOfWeek(),
        now()->endOfWeek()
    ])
    ->groupBy('tanggal')
    ->get();
    return view('home', compact(
    'totalProduk',
    'barangHabis',
    'transaksiHariIni',
    'totalPenjualan',
    'transaksiTerakhir',
    'statusBarang', 'grafik'
    ));
    }
    }
