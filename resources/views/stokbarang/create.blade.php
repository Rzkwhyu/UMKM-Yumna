<h1>Tambah Barang Masuk</h1>

<form action="{{ route('stokbarang.store') }}"
      method="POST">

    @csrf

    <select name="barang_id" required>

        <option value="">
            -- Pilih Barang --
        </option>

        @foreach ($barang as $item)

            <option value="{{ $item->id }}">
                {{ $item->nama_barang }}
            </option>

        @endforeach

    </select>

    <br><br>

    <input type="date"
           name="tanggal_masuk"
           required>

    <br><br>

    <input type="text"
           name="no_transaksi"
           placeholder="No Transaksi"
           required>

    <br><br>

    <select name="suplier_id" required>

        <option value="">
            -- Pilih Supplier --
        </option>

        @foreach ($suplier as $item)

            <option value="{{ $item->id }}">
                {{ $item->nama_pt }}
            </option>

        @endforeach

    </select>

    <br><br>

    <input type="number"
           name="qty"
           placeholder="Qty"
           required>

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>