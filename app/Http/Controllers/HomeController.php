<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalProduk = Barang::count();

        $barangHabis = Barang::where('stok', '<=', 20)->count();

        $transaksiHariIni = $this->groupTransaksiByNota(
            Transaksi::whereDate('created_at', now()->toDateString())->get()
        )->count();

        $totalPenjualan = Transaksi::whereDate(
            'created_at',
            now()->toDateString()
        )->sum('total_harga');

        $statusBarang = Barang::all();

        $transaksiTerakhir = $this->groupTransaksiByNota(
            Transaksi::latest()->get()
        )->take(5);

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

    /**
     * Gabungkan baris transaksi per nomor nota.
     *
     * @return Collection<int, object>
     */
    private function groupTransaksiByNota(Collection $transaksi): Collection
    {
        return $transaksi
            ->groupBy(fn ($item) => $item->no_transaksi ?: 'legacy-' . $item->id)
            ->map(function ($items) {
                $first = $items->first();

                return (object) [
                    'no_transaksi' => $first->no_transaksi,
                    'label_nota' => $first->no_transaksi ?: ('#' . str_pad($first->id, 4, '0', STR_PAD_LEFT)),
                    'tanggal' => $first->created_at,
                    'total_qty' => $items->sum('qty'),
                    'total_harga' => $items->sum('total_harga'),
                    'jumlah_item' => $items->count(),
                ];
            })
            ->sortByDesc(fn ($group) => $group->tanggal)
            ->values();
    }
}
