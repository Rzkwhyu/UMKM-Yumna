<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota {{ $nota->no_transaksi }}</title>
    <style>
        @page {
            size: 58mm auto;
            margin: 2mm 1mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 58mm;
            max-width: 58mm;
            margin: 0 auto;
            background: #fff;
            color: #000;
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            line-height: 1.35;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .nota {
            width: 58mm;
            padding: 4px 2px 8px;
        }

        .nota pre {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
            white-space: pre;
            margin: 0;
            width: 100%;
        }

        .nota-title {
            text-align: center;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 2px;
        }

        .nota-subtitle {
            text-align: center;
            font-size: 10px;
            margin-bottom: 4px;
        }

        .nota-meta {
            font-size: 10px;
            word-break: break-all;
            margin-bottom: 2px;
        }

        .nota-pembeli {
            font-size: 10px;
            margin-bottom: 2px;
        }

        .nota-footer {
            text-align: center;
            font-size: 10px;
            margin-top: 6px;
        }

        .screen-actions {
            width: 58mm;
            margin: 12px auto;
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .screen-actions button {
            padding: 8px 14px;
            border: none;
            border-radius: 8px;
            background: #6b7280;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        @media print {
            .screen-actions {
                display: none;
            }

            html,
            body {
                width: 58mm;
            }
        }
    </style>
</head>
<body>
    <div class="nota">
        <div class="nota-title">YUMNA</div>
        <div class="nota-subtitle">NOTA PENJUALAN</div>

        <pre>{{ $nota->garis }}</pre>
        <div class="nota-meta">{{ $nota->meta_line }}</div>
        <div class="nota-pembeli">PEMBELI : {{ $nota->nama_pembeli }}</div>
        <pre>{{ $nota->garis }}</pre>

        <pre>BARANG          QT HARGA SUBTOTAL</pre>
        @foreach ($nota->items as $item)
            <pre>{{ $item->line }}</pre>
        @endforeach

        <pre>{{ $nota->garis }}</pre>
        <pre>{{ $nota->harga_jual_line }}</pre>
        <pre>{{ $nota->total_line }}</pre>
        <pre>{{ $nota->tunai_line }}</pre>
        <pre>{{ $nota->garis }}</pre>

        <div class="nota-footer">
            QTY TOTAL : {{ $nota->total_qty }}<br>
            TERIMA KASIH
        </div>
    </div>

    <div class="screen-actions">
        <button type="button" onclick="window.print()">Cetak</button>
        <button type="button" onclick="window.close()">Tutup</button>
    </div>

    <script>
        window.addEventListener('load', function () {
            setTimeout(function () {
                window.print();
            }, 300);
        });
    </script>
</body>
</html>
