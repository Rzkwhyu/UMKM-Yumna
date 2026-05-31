@extends('layouts.yumna')

@section('body-class', 'page-yumna page-transaksi-pos')

@section('title', 'Transaksi — Yumna')

@section('header-toolbar')
    <select class="filter-select" id="filterPosKategori">
        <option value="">Kategori : Semua</option>
        @foreach ($kategori as $item)
            <option value="{{ $item->id }}">{{ $item->kategori }}</option>
        @endforeach
    </select>
    <a href="{{ route('transaksi.index') }}" class="btn-tambah">
        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat
    </a>
@endsection

@push('styles')
    @include('partials.transaksi-pos-styles')
@endpush

@section('content')
<div class="pos-page">
    <div class="pos-main">
        <section class="pos-products">
            @if ($errors->any())
                <div class="pos-alert">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('error'))
                <div class="pos-alert">{{ session('error') }}</div>
            @endif

            <div class="pos-product-list" id="posProductList">
            @foreach ($barang as $item)
                <article
                    class="pos-product {{ $item->stok <= 0 ? 'is-out-of-stock' : '' }}"
                    data-barang-id="{{ $item->id }}"
                    data-kategori-id="{{ $item->kategori_id }}"
                    data-nama="{{ strtolower($item->nama_barang) }}"
                    data-nama-label="{{ $item->nama_barang }}"
                    data-kategori="{{ $item->kategori->kategori ?? '-' }}"
                    data-harga="{{ $item->harga }}"
                    data-stok="{{ $item->stok }}"
                    data-gambar="{{ $item->gambar ? asset($item->gambar) : '' }}"
                >
                    <div class="pos-product-thumb">
                        @if ($item->gambar)
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_barang }}">
                        @else
                            <i class="fa-solid fa-box"></i>
                        @endif
                    </div>
                    <div class="pos-product-info">
                        <h3>{{ $item->nama_barang }}</h3>
                        <div class="pos-kategori">{{ $item->kategori->kategori ?? '-' }}</div>
                        <div class="pos-harga">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                    </div>
                    <div class="pos-qty-control">
                        <button type="button" class="pos-qty-btn pos-qty-minus" aria-label="Kurangi" disabled>−</button>
                        <span class="pos-qty-value">0</span>
                        <button type="button" class="pos-qty-btn pos-qty-plus" aria-label="Tambah" {{ $item->stok <= 0 ? 'disabled' : '' }}>+</button>
                    </div>
                </article>
            @endforeach
            </div>
        </section>

        <aside class="pos-cart">
            <div class="pos-cart-head">
                <i class="fa-solid fa-cart-shopping"></i>
                <h2>Item(s)</h2>
            </div>

            <div class="pos-cart-items" id="posCartItems">
                <p class="pos-cart-empty" id="posCartEmpty">Belum ada item dipilih.</p>
            </div>

            <div class="pos-total-box">
                <strong id="posTotalDisplay">Rp.0</strong>
            </div>

            <form action="{{ route('transaksi.store') }}" method="POST" id="posCheckoutForm">
                @csrf
                <input type="hidden" name="nama_pembeli" value="Pelanggan Umum">

                <div id="posItemsContainer"></div>

                <div class="pos-payment-field">
                    <input
                        type="number"
                        name="uang_bayar"
                        id="posUangBayar"
                        min="0"
                        placeholder="Masukan Jumlah uang..."
                        value="{{ old('uang_bayar') }}"
                        required
                    >
                </div>

                <div class="pos-payment-field">
                    <input
                        type="text"
                        id="posKembalian"
                        placeholder="Kembalian..."
                        readonly
                    >
                </div>

                <div class="pos-actions">
                    <button type="submit" class="pos-btn" id="posBtnSelesai" disabled>Selesai</button>
                    <button type="button" class="pos-btn pos-btn--secondary" id="posBtnCetak" disabled>Cetak</button>
                </div>
            </form>
        </aside>
    </div>
</div>

<div id="posPrintArea" style="display:none;"></div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('filterPosKategori');
        const search = document.getElementById('yumnaSearchInput');
        const products = document.querySelectorAll('.pos-product');
        const cartItemsEl = document.getElementById('posCartItems');
        const cartEmptyEl = document.getElementById('posCartEmpty');
        const totalDisplay = document.getElementById('posTotalDisplay');
        const uangBayarInput = document.getElementById('posUangBayar');
        const kembalianInput = document.getElementById('posKembalian');
        const itemsContainer = document.getElementById('posItemsContainer');
        const checkoutForm = document.getElementById('posCheckoutForm');
        const btnSelesai = document.getElementById('posBtnSelesai');
        const btnCetak = document.getElementById('posBtnCetak');
        const printArea = document.getElementById('posPrintArea');

        const cart = new Map();

        function formatRupiah(value) {
            return 'Rp.' + Number(value || 0).toLocaleString('id-ID');
        }

        function applyProductFilters() {
            const selectedKategori = filter ? filter.value : '';
            const query = search ? search.value.trim().toLowerCase() : '';

            products.forEach(function (product) {
                const matchKategori = !selectedKategori || product.dataset.kategoriId === selectedKategori;
                const matchSearch = !query || product.dataset.nama.includes(query);
                product.classList.toggle('is-hidden', !(matchKategori && matchSearch));
            });
        }

        if (filter) {
            filter.addEventListener('change', applyProductFilters);
        }

        if (search) {
            search.placeholder = 'Cari barang...';
            search.addEventListener('input', applyProductFilters);
        }

        function syncProductQtyDisplay(barangId, qty) {
            const product = document.querySelector('.pos-product[data-barang-id="' + barangId + '"]');
            if (!product) return;

            const valueEl = product.querySelector('.pos-qty-value');
            const minusBtn = product.querySelector('.pos-qty-minus');
            const plusBtn = product.querySelector('.pos-qty-plus');
            const stok = parseInt(product.dataset.stok, 10) || 0;

            if (valueEl) valueEl.textContent = qty;
            if (minusBtn) minusBtn.disabled = qty <= 0;
            if (plusBtn) plusBtn.disabled = qty >= stok || stok <= 0;
        }

        function setCartQty(barangId, qty) {
            const product = document.querySelector('.pos-product[data-barang-id="' + barangId + '"]');
            if (!product) return;

            const stok = parseInt(product.dataset.stok, 10) || 0;
            const safeQty = Math.max(0, Math.min(qty, stok));

            if (safeQty === 0) {
                cart.delete(String(barangId));
            } else {
                cart.set(String(barangId), {
                    id: barangId,
                    nama: product.dataset.namaLabel,
                    kategori: product.dataset.kategori,
                    harga: parseInt(product.dataset.harga, 10) || 0,
                    stok: stok,
                    gambar: product.dataset.gambar,
                    qty: safeQty,
                });
            }

            syncProductQtyDisplay(barangId, safeQty);
            renderCart();
        }

        products.forEach(function (product) {
            const barangId = product.dataset.barangId;
            const minusBtn = product.querySelector('.pos-qty-minus');
            const plusBtn = product.querySelector('.pos-qty-plus');

            if (minusBtn) {
                minusBtn.addEventListener('click', function () {
                    const current = cart.get(String(barangId))?.qty || 0;
                    setCartQty(barangId, current - 1);
                });
            }

            if (plusBtn) {
                plusBtn.addEventListener('click', function () {
                    const current = cart.get(String(barangId))?.qty || 0;
                    setCartQty(barangId, current + 1);
                });
            }
        });

        function renderCart() {
            const entries = Array.from(cart.values());
            let total = 0;

            cartItemsEl.querySelectorAll('.pos-cart-item').forEach(function (node) {
                node.remove();
            });

            if (entries.length === 0) {
                cartEmptyEl.hidden = false;
                btnSelesai.disabled = true;
                btnCetak.disabled = true;
            } else {
                cartEmptyEl.hidden = true;
                btnSelesai.disabled = false;
                btnCetak.disabled = false;

                entries.forEach(function (item) {
                    total += item.harga * item.qty;

                    const row = document.createElement('div');
                    row.className = 'pos-cart-item';
                    row.innerHTML =
                        '<div class="pos-cart-item-thumb">' +
                            (item.gambar
                                ? '<img src="' + item.gambar + '" alt="">'
                                : '<i class="fa-solid fa-box"></i>') +
                        '</div>' +
                        '<div class="pos-cart-item-info">' +
                            '<h4>' + item.nama + '</h4>' +
                            '<span>' + formatRupiah(item.harga) + '</span>' +
                        '</div>' +
                        '<div class="pos-cart-item-qty">' + item.qty + 'x</div>';

                    cartItemsEl.appendChild(row);
                });
            }

            totalDisplay.textContent = formatRupiah(total);
            updateKembalian(total);
            buildHiddenInputs(entries);
        }

        function updateKembalian(total) {
            const bayar = parseInt(uangBayarInput.value, 10) || 0;
            const kembalian = bayar - total;
            kembalianInput.value = bayar > 0 ? formatRupiah(Math.max(kembalian, 0)) : '';
        }

        function buildHiddenInputs(entries) {
            itemsContainer.innerHTML = '';

            entries.forEach(function (item, index) {
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.name = 'items[' + index + '][barang_id]';
                idInput.value = item.id;
                itemsContainer.appendChild(idInput);

                const qtyInput = document.createElement('input');
                qtyInput.type = 'hidden';
                qtyInput.name = 'items[' + index + '][qty]';
                qtyInput.value = item.qty;
                itemsContainer.appendChild(qtyInput);
            });
        }

        if (uangBayarInput) {
            uangBayarInput.addEventListener('input', function () {
                let total = 0;
                cart.forEach(function (item) {
                    total += item.harga * item.qty;
                });
                updateKembalian(total);
            });
        }

        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function (e) {
                if (cart.size === 0) {
                    e.preventDefault();
                    alert('Pilih minimal satu barang.');
                    return;
                }

                let total = 0;
                cart.forEach(function (item) {
                    total += item.harga * item.qty;
                });

                const bayar = parseInt(uangBayarInput.value, 10) || 0;
                if (bayar < total) {
                    e.preventDefault();
                    alert('Jumlah uang pembayaran kurang dari total belanja.');
                }
            });
        }

        if (btnCetak) {
            btnCetak.addEventListener('click', function () {
                if (cart.size === 0) return;

                let total = 0;
                let rowsHtml = '';

                cart.forEach(function (item) {
                    const subtotal = item.harga * item.qty;
                    total += subtotal;
                    rowsHtml +=
                        '<tr>' +
                            '<td>' + item.nama + '</td>' +
                            '<td>' + item.qty + 'x</td>' +
                            '<td>' + formatRupiah(subtotal) + '</td>' +
                        '</tr>';
                });

                const bayar = parseInt(uangBayarInput.value, 10) || 0;
                const kembalian = Math.max(bayar - total, 0);

                printArea.innerHTML =
                    '<div style="font-family:Arial,sans-serif;padding:24px;max-width:360px;">' +
                        '<h2 style="margin-bottom:8px;">YUMNA</h2>' +
                        '<p style="margin-bottom:16px;color:#666;">' + new Date().toLocaleString('id-ID') + '</p>' +
                        '<table style="width:100%;border-collapse:collapse;font-size:13px;margin-bottom:16px;">' +
                            '<thead><tr><th align="left">Item</th><th align="center">Qty</th><th align="right">Subtotal</th></tr></thead>' +
                            '<tbody>' + rowsHtml + '</tbody>' +
                        '</table>' +
                        '<p><strong>Total: ' + formatRupiah(total) + '</strong></p>' +
                        '<p>Bayar: ' + formatRupiah(bayar) + '</p>' +
                        '<p>Kembalian: ' + formatRupiah(kembalian) + '</p>' +
                    '</div>';

                const printWindow = window.open('', '_blank', 'width=420,height=640');
                if (!printWindow) return;

                printWindow.document.write('<html><head><title>Struk Transaksi</title></head><body>');
                printWindow.document.write(printArea.innerHTML);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
            });
        }

        renderCart();
    });
</script>
@endpush
