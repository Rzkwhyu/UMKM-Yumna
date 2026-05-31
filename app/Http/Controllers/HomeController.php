<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;

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

    $hariLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
    $penjualanMingguan = [];
    $startOfWeek = now()->startOfWeek();

    for ($i = 0; $i < 7; $i++) {
        $penjualanMingguan[] = (int) Transaksi::whereDate(
            'created_at',
            $startOfWeek->copy()->addDays($i)->toDateString()
        )->sum('total_harga');
    }

    $maxPenjualanMingguan = max($penjualanMingguan) ?: 1;
    $maxStok = max((int) $statusBarang->max('stok'), 1);

    $penjualanFormatted = $totalPenjualan >= 1_000_000
        ? number_format($totalPenjualan / 1_000_000, 1, ',', '') . 'jt'
        : number_format($totalPenjualan, 0, ',', '.');

    return view('home', compact(
        'totalProduk',
        'barangHabis',
        'transaksiHariIni',
        'totalPenjualan',
        'penjualanFormatted',
        'transaksiTerakhir',
        'statusBarang',
        'hariLabels',
        'penjualanMingguan',
        'maxPenjualanMingguan',
        'maxStok'
    ));
    }
}
