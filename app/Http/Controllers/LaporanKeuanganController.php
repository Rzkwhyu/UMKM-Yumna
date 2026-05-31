<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LaporanKeuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman laporan keuangan dengan filter periode.
     */
    public function index(Request $request)
    {
        $mulai = Carbon::parse(
            $request->input('tanggal_mulai', now()->startOfMonth()->format('Y-m-d'))
        )->startOfDay();

        $selesai = Carbon::parse(
            $request->input('tanggal_selesai', now()->endOfMonth()->format('Y-m-d'))
        )->endOfDay();

        if ($mulai->gt($selesai)) {
            [$mulai, $selesai] = [$selesai->copy()->startOfDay(), $mulai->copy()->endOfDay()];
        }

        $jenisLaporan = $request->input('jenis', 'ringkasan');

        $transaksi = Transaksi::with('barang')
            ->whereBetween('created_at', [$mulai, $selesai])
            ->get();

        $stokMasuk = StokBarang::with('barang')
            ->whereBetween('tanggal_masuk', [
                $mulai->toDateString(),
                $selesai->toDateString(),
            ])
            ->get();

        $totalPendapatan = (int) $transaksi->sum('total_harga');
        $totalPengeluaran = (int) $stokMasuk->sum(
            fn ($row) => $row->qty * (int) ($row->barang?->harga ?? 0)
        );
        $labaBersih = $totalPendapatan - $totalPengeluaran;
        $totalPenjualan = $totalPendapatan;

        $grafikBulanan = $this->buildGrafikBulanan($mulai, $selesai, $transaksi, $stokMasuk);
        $ringkasanDonut = $this->buildRingkasanDonut($totalPendapatan, $totalPengeluaran);
        $pendapatanTerbesar = $this->buildPendapatanTerbesar($transaksi);
        $pengeluaranTerbesar = $this->buildPengeluaranTerbesar($stokMasuk);

        return view('laporan.index', compact(
            'mulai',
            'selesai',
            'jenisLaporan',
            'totalPendapatan',
            'totalPengeluaran',
            'labaBersih',
            'totalPenjualan',
            'grafikBulanan',
            'ringkasanDonut',
            'pendapatanTerbesar',
            'pengeluaranTerbesar'
        ));
    }

    /**
     * Data grafik batang pendapatan vs pengeluaran per bulan.
     *
     * @return array{labels: array<int, string>, pendapatan: array<int, int>, pengeluaran: array<int, int>}
     */
    private function buildGrafikBulanan(
        Carbon $mulai,
        Carbon $selesai,
        Collection $transaksi,
        Collection $stokMasuk
    ): array {
        $labels = [];
        $pendapatan = [];
        $pengeluaran = [];

        $cursor = $mulai->copy()->startOfMonth();
        $end = $selesai->copy()->endOfMonth();

        $bulanSingkat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        while ($cursor->lte($end)) {
            $monthStart = $cursor->copy()->startOfMonth();
            $monthEnd = $cursor->copy()->endOfMonth();

            $labels[] = $bulanSingkat[$cursor->month - 1];

            $pendapatan[] = (int) $transaksi
                ->filter(fn ($t) => $t->created_at->between($monthStart, $monthEnd))
                ->sum('total_harga');

            $pengeluaran[] = (int) $stokMasuk
                ->filter(function ($s) use ($monthStart, $monthEnd) {
                    $tanggal = Carbon::parse($s->tanggal_masuk);

                    return $tanggal->between($monthStart, $monthEnd);
                })
                ->sum(fn ($row) => $row->qty * (int) ($row->barang?->harga ?? 0));

            $cursor->addMonth();
        }

        if (count($labels) > 6) {
            $labels = array_slice($labels, -6);
            $pendapatan = array_slice($pendapatan, -6);
            $pengeluaran = array_slice($pengeluaran, -6);
        }

        return compact('labels', 'pendapatan', 'pengeluaran');
    }

    /**
     * Segmen ringkasan untuk grafik donat.
     *
     * @return array<int, array{label: string, nilai: int, warna: string}>
     */
    private function buildRingkasanDonut(int $pendapatan, int $pengeluaran): array
    {
        return [
            [
                'label' => 'Penjualan Tunai',
                'nilai' => $pendapatan,
                'warna' => '#22c55e',
            ],
            [
                'label' => 'Penjualan Kredit',
                'nilai' => 0,
                'warna' => '#eab308',
            ],
            [
                'label' => 'Barang Masuk',
                'nilai' => $pengeluaran,
                'warna' => '#3b82f6',
            ],
            [
                'label' => 'Biaya Operasional',
                'nilai' => 0,
                'warna' => '#ef4444',
            ],
        ];
    }

    /**
     * Daftar pendapatan terbesar (per nota transaksi).
     *
     * @return Collection<int, object>
     */
    private function buildPendapatanTerbesar(Collection $transaksi): Collection
    {
        return $this->groupTransaksiByNota($transaksi)
            ->sortByDesc('total_harga')
            ->take(5)
            ->values()
            ->map(function ($group, $index) {
                return (object) [
                    'no' => $index + 1,
                    'tanggal' => $group->tanggal,
                    'keterangan' => 'Penjualan — ' . $group->label_nota,
                    'jumlah' => $group->total_harga,
                ];
            });
    }

    /**
     * Daftar pengeluaran terbesar (per nota stok masuk).
     *
     * @return Collection<int, object>
     */
    private function buildPengeluaranTerbesar(Collection $stokMasuk): Collection
    {
        return $stokMasuk
            ->groupBy(fn ($row) => $row->no_transaksi ?: 'legacy-' . $row->id)
            ->map(function ($items) {
                $first = $items->first();
                $total = $items->sum(
                    fn ($row) => $row->qty * (int) ($row->barang?->harga ?? 0)
                );

                return (object) [
                    'tanggal' => Carbon::parse($first->tanggal_masuk),
                    'keterangan' => 'Pembelian Barang Dagang — ' . ($first->no_transaksi ?: '#' . $first->id),
                    'jumlah' => $total,
                ];
            })
            ->sortByDesc('jumlah')
            ->take(5)
            ->values()
            ->map(function ($group, $index) {
                $group->no = $index + 1;

                return $group;
            });
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
                    'total_harga' => $items->sum('total_harga'),
                ];
            })
            ->values();
    }
}
