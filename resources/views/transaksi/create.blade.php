<h1>Tambah Transaksi</h1>
@if(session('error'))

    <p>{{ session('error') }}</p>

@endif

<form action="{{ route('transaksi.store') }}"
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

    <input type="text"
           name="nama_pembeli"
           placeholder="Nama Pembeli"
           required>

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