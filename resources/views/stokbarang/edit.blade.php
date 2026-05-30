<h1>Edit Barang Masuk</h1>

<form action="{{ route('stokbarang.update', $stokbarang->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <select name="barang_id">

        @foreach ($barang as $item)

            <option value="{{ $item->id }}"
                {{ $stokbarang->barang_id == $item->id ? 'selected' : '' }}>

                {{ $item->nama_barang }}

            </option>

        @endforeach

    </select>

    <br><br>

    <input type="date"
           name="tanggal_masuk"
           value="{{ $stokbarang->tanggal_masuk }}">

    <br><br>

    <input type="text"
           name="no_transaksi"
           value="{{ $stokbarang->no_transaksi }}">

    <br><br>

    <select name="suplier_id">

        @foreach ($suplier as $item)

            <option value="{{ $item->id }}"
                {{ $stokbarang->suplier_id == $item->id ? 'selected' : '' }}>

                {{ $item->nama_pt }}

            </option>

        @endforeach

    </select>

    <br><br>

    <input type="number"
           name="qty"
           value="{{ $stokbarang->qty }}">

    <br><br>

    <button type="submit">
        Update
    </button>

</form>