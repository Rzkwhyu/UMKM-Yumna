<h1>Edit Transaksi</h1>

<form action="{{ route('transaksi.update', $transaksi->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <select name="barang_id">

        @foreach ($barang as $item)

            <option value="{{ $item->id }}"
                {{ $transaksi->barang_id == $item->id ? 'selected' : '' }}>

                {{ $item->nama_barang }}

            </option>

        @endforeach

    </select>

    <br><br>

    <input type="text"
           name="nama_pembeli"
           value="{{ $transaksi->nama_pembeli }}">

    <br><br>

    <input type="number"
           name="qty"
           value="{{ $transaksi->qty }}">

    <br><br>

    <button type="submit">
        Update
    </button>

</form>