@extends('layouts.yumna')

@section('body-class', 'page-yumna page-laporan')

@section('title', 'Laporan Keuangan — Yumna')

@push('styles')
    @include('partials.laporan-page-styles')
@endpush

@section('content')
@php
    $bulanSingkat = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    $formatRingkas = function (int $nilai): string {
        if ($nilai >= 1_000_000) {
            $jt = $nilai / 1_000_000;
            $formatted = fmod($jt, 1.0) === 0.0
                ? number_format($jt, 0, ',', '.')
                : number_format($jt, 1, ',', '.');

            return str_contains($formatted, ',') ? $formatted . ' jt' : $formatted . 'jt';
        }

        if ($nilai >= 1_000) {
            return number_format($nilai / 1_000, 0, ',', '.') . 'rb';
        }

        return (string) $nilai;
    };

    $formatRupiah = fn (int $nilai): string => 'Rp ' . number_format($nilai, 0, ',', '.');

    $totalDonut = array_sum(array_column($ringkasanDonut, 'nilai'));
    $donutCenter = $formatRupiah($totalDonut > 0 ? $totalDonut : ($totalPendapatan + $totalPengeluaran));
@endphp

<div class="laporan-page">
    <div class="laporan-inner">
        <div class="laporan-head">
            <h2>Laporan Keuangan</h2>
            <p>Ringkasan laporan keuangan toko</p>
        </div>

        <form method="GET" action="{{ route('laporan.index') }}" class="laporan-filters">
            <div class="laporan-field">
                <label for="tanggal_mulai">Periode</label>
                <div class="laporan-periode-wrap">
                    <input
                        type="date"
                        id="tanggal_mulai"
                        name="tanggal_mulai"
                        value="{{ $mulai->format('Y-m-d') }}"
                    >
                    <span class="laporan-periode-sep">s/d</span>
                    <input
                        type="date"
                        id="tanggal_selesai"
                        name="tanggal_selesai"
                        value="{{ $selesai->format('Y-m-d') }}"
                    >
                </div>
            </div>

            <div class="laporan-field">
                <label for="jenis">Jenis Laporan</label>
                <select id="jenis" name="jenis">
                    <option value="ringkasan" {{ $jenisLaporan === 'ringkasan' ? 'selected' : '' }}>Ringkasan keuangan</option>
                    <option value="pendapatan" {{ $jenisLaporan === 'pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                    <option value="pengeluaran" {{ $jenisLaporan === 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>

            <button type="submit" class="btn-tampilkan">
                <i class="fa-solid fa-eye"></i> Tampilkan
            </button>
        </form>

        <div class="laporan-stats">
            <div class="laporan-stat-card">
                <div class="laporan-stat-icon"><i class="fa-solid fa-box"></i></div>
                <div>
                    <div class="laporan-stat-label">Total Pendapatan</div>
                    <div class="laporan-stat-value">{{ $formatRingkas($totalPendapatan) }}</div>
                </div>
            </div>
            <div class="laporan-stat-card">
                <div class="laporan-stat-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                <div>
                    <div class="laporan-stat-label">Total Pengeluaran</div>
                    <div class="laporan-stat-value">{{ $formatRingkas($totalPengeluaran) }}</div>
                </div>
            </div>
            <div class="laporan-stat-card">
                <div class="laporan-stat-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                <div>
                    <div class="laporan-stat-label">Laba Bersih</div>
                    <div class="laporan-stat-value">{{ $formatRingkas($labaBersih) }}</div>
                </div>
            </div>
            <div class="laporan-stat-card">
                <div class="laporan-stat-icon"><i class="fa-solid fa-wallet"></i></div>
                <div>
                    <div class="laporan-stat-label">Total Penjualan</div>
                    <div class="laporan-stat-value">{{ $formatRingkas($totalPenjualan) }}</div>
                </div>
            </div>
        </div>

        <div class="laporan-charts">
            <div class="laporan-panel">
                <div class="laporan-panel-head">
                    <h3>Grafik Pendapatan vs Pengeluaran</h3>
                    <select id="grafikPeriode" aria-label="Periode grafik">
                        <option value="bulan" selected>Per Bulan</option>
                    </select>
                </div>
                <div class="laporan-chart-wrap">
                    <canvas id="chartPendapatanPengeluaran" aria-label="Grafik pendapatan vs pengeluaran"></canvas>
                </div>
            </div>

            <div class="laporan-panel">
                <div class="laporan-panel-head">
                    <h3>Ringkasan Keuangan</h3>
                </div>
                <div class="laporan-donut-wrap">
                    <canvas id="chartRingkasan" aria-label="Ringkasan keuangan"></canvas>
                </div>
                <div class="laporan-donut-legend">
                    @foreach ($ringkasanDonut as $segmen)
                        @php
                            $pct = $totalDonut > 0
                                ? round(($segmen['nilai'] / $totalDonut) * 100, 1)
                                : 0;
                        @endphp
                        <div class="laporan-legend-item">
                            <span class="laporan-legend-left">
                                <span class="laporan-legend-dot" style="background: {{ $segmen['warna'] }}"></span>
                                {{ $segmen['label'] }}
                            </span>
                            <strong>{{ $formatRupiah($segmen['nilai']) }} ({{ $pct }}%)</strong>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="laporan-tables">
            <div class="laporan-panel laporan-table-panel">
                <h3>Pendapatan Terbesar</h3>
                <table class="laporan-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendapatanTerbesar as $row)
                            <tr>
                                <td>{{ $row->no }}</td>
                                <td>
                                    {{ $row->tanggal->format('d') }}
                                    {{ $bulanSingkat[$row->tanggal->month - 1] }}
                                    {{ $row->tanggal->format('Y') }}
                                </td>
                                <td>{{ $row->keterangan }}</td>
                                <td>{{ $formatRupiah($row->jumlah) }}</td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="4">Belum ada data pendapatan pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('transaksi.index') }}" class="laporan-link-all">Lihat Semua &rarr;</a>
            </div>

            <div class="laporan-panel laporan-table-panel">
                <h3>Pengeluaran Terbesar</h3>
                <table class="laporan-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengeluaranTerbesar as $row)
                            <tr>
                                <td>{{ $row->no }}</td>
                                <td>
                                    {{ $row->tanggal->format('d') }}
                                    {{ $bulanSingkat[$row->tanggal->month - 1] }}
                                    {{ $row->tanggal->format('Y') }}
                                </td>
                                <td>{{ $row->keterangan }}</td>
                                <td>{{ $formatRupiah($row->jumlah) }}</td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="4">Belum ada data pengeluaran pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <a href="{{ route('stokbarang.index') }}" class="laporan-link-all">Lihat Semua &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($grafikBulanan['labels']);
        const pendapatan = @json($grafikBulanan['pendapatan']);
        const pengeluaran = @json($grafikBulanan['pengeluaran']);
        const donutLabels = @json(array_column($ringkasanDonut, 'label'));
        const donutValues = @json(array_column($ringkasanDonut, 'nilai'));
        const donutColors = @json(array_column($ringkasanDonut, 'warna'));
        const donutCenterText = @json($donutCenter);

        const maxVal = Math.max(...pendapatan, ...pengeluaran, 1);
        const yMax = maxVal > 0 ? Math.ceil(maxVal * 1.2 / 1_000_000) * 1_000_000 : 1_000_000;

        const barCtx = document.getElementById('chartPendapatanPengeluaran');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Pendapatan',
                            data: pendapatan,
                            backgroundColor: '#22c55e',
                            borderRadius: 6,
                            maxBarThickness: 36,
                        },
                        {
                            label: 'Pengeluaran',
                            data: pengeluaran,
                            backgroundColor: '#f87171',
                            borderRadius: 6,
                            maxBarThickness: 36,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 12, padding: 16, font: { size: 12 } },
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 12 } },
                        },
                        y: {
                            beginAtZero: true,
                            max: yMax,
                            ticks: {
                                callback: function (value) {
                                    if (value >= 1_000_000) {
                                        return (value / 1_000_000) + 'jt';
                                    }
                                    return value;
                                },
                                font: { size: 11 },
                            },
                            grid: { color: '#f3f4f6' },
                        },
                    },
                },
            });
        }

        const donutCtx = document.getElementById('chartRingkasan');
        if (donutCtx) {
            const centerText = {
                id: 'centerText',
                beforeDraw(chart) {
                    const { ctx, chartArea: { top, bottom, left, right } } = chart;
                    const cx = (left + right) / 2;
                    const cy = (top + bottom) / 2;
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillStyle = '#1f2937';
                    ctx.font = '600 11px Inter, sans-serif';
                    ctx.fillText('Total', cx, cy - 10);
                    ctx.font = '700 13px Inter, sans-serif';
                    ctx.fillText(donutCenterText, cx, cy + 10);
                    ctx.restore();
                },
            };

            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: donutLabels,
                    datasets: [{
                        data: donutValues,
                        backgroundColor: donutColors,
                        borderWidth: 0,
                        hoverOffset: 4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    const val = ctx.raw || 0;
                                    return ctx.label + ': Rp ' + val.toLocaleString('id-ID');
                                },
                            },
                        },
                    },
                },
                plugins: [centerText],
            });
        }

        const search = document.getElementById('yumnaSearchInput');
        if (search) {
            search.placeholder = 'Cari laporan...';
        }
    });
</script>
@endpush
