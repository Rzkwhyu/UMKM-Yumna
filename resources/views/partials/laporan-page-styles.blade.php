@once
<style>
    body.page-laporan {
        overflow: auto;
    }

    body.page-laporan .yumna-app,
    body.page-laporan .yumna-frame {
        height: auto;
        max-height: none;
        min-height: 100dvh;
        overflow: visible;
    }

    body.page-laporan .yumna-main {
        overflow: visible;
        min-height: auto;
        flex: 1 1 auto;
    }

    body.page-laporan .yumna-hero-arch {
        flex: 0 0 auto;
        height: clamp(200px, 28vh, 320px);
        max-height: none;
    }

    body.page-laporan .yumna-content {
        flex: 0 0 auto;
        overflow: visible;
        background: transparent;
    }

    .laporan-page {
        position: relative;
        padding: 24px 40px 48px;
        min-height: calc(100vh - var(--yumna-chrome-h) - 120px);
    }

    .laporan-page::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url('{{ asset('image/bckgrndyumna.jpeg') }}');
        background-size: cover;
        background-position: center;
        filter: blur(8px);
        opacity: 0.35;
        z-index: 0;
    }

    .laporan-inner {
        position: relative;
        z-index: 1;
        max-width: 1320px;
        margin: 0 auto;
    }

    .laporan-head {
        margin-bottom: 22px;
    }

    .laporan-head h2 {
        font-size: 28px;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .laporan-head p {
        font-size: 14px;
        color: #6b7280;
    }

    .laporan-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 16px 24px;
        margin-bottom: 24px;
        padding: 18px 22px;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    }

    .laporan-field label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 6px;
    }

    .laporan-field input,
    .laporan-field select {
        font-family: inherit;
        font-size: 14px;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fff;
        color: #1f2937;
        min-width: 160px;
    }

    .laporan-periode-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .laporan-periode-wrap input[type="date"] {
        min-width: 150px;
    }

    .laporan-periode-sep {
        color: #9ca3af;
        font-size: 13px;
    }

    .btn-tampilkan {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: #4a3728;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-tampilkan:hover {
        background: #3d2e22;
    }

    .laporan-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .laporan-stat-card {
        background-image: url('{{ asset('image/bckgrnd1.png') }}');
        background-size: cover;
        background-position: center;
        border-radius: 18px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        min-height: 96px;
    }

    .laporan-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 20px;
        flex-shrink: 0;
    }

    .laporan-stat-label {
        font-size: 12px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 4px;
    }

    .laporan-stat-value {
        font-size: 24px;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
    }

    .laporan-charts {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    .laporan-panel {
        background: rgba(255, 255, 255, 0.96);
        border-radius: 18px;
        padding: 20px 22px 24px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
    }

    .laporan-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .laporan-panel-head h3 {
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
    }

    .laporan-panel-head select {
        font-size: 12px;
        padding: 6px 10px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
    }

    .laporan-chart-wrap {
        position: relative;
        height: 280px;
    }

    .laporan-donut-wrap {
        position: relative;
        height: 260px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .laporan-donut-legend {
        margin-top: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .laporan-legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 12px;
        color: #4b5563;
    }

    .laporan-legend-left {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 0;
    }

    .laporan-legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .laporan-legend-item strong {
        font-weight: 600;
        color: #1f2937;
        white-space: nowrap;
    }

    .laporan-tables {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .laporan-table-panel h3 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 14px;
        color: #1f2937;
    }

    .laporan-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .laporan-table th {
        text-align: left;
        padding: 10px 8px;
        font-weight: 600;
        color: #6b7280;
        border-bottom: 2px solid #f3f4f6;
    }

    .laporan-table td {
        padding: 10px 8px;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
    }

    .laporan-table td:last-child {
        font-weight: 600;
        color: #1f2937;
        text-align: right;
    }

    .laporan-table .empty-row td {
        text-align: center;
        color: #9ca3af;
        padding: 24px 8px;
    }

    .laporan-link-all {
        display: inline-block;
        margin-top: 12px;
        font-size: 13px;
        font-weight: 600;
        color: #4a3728;
    }

    .laporan-link-all:hover {
        text-decoration: underline;
    }

    @media (max-width: 1100px) {
        .laporan-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .laporan-charts,
        .laporan-tables {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .laporan-page {
            padding: 16px 16px 32px;
        }

        .laporan-stats {
            grid-template-columns: 1fr;
        }

        .laporan-filters {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
@endonce
