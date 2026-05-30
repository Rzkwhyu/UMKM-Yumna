<h1>Tambah Barang</h1>

<form action="{{ route('barang.store') }}" method="POST">
    @csrf

    <input type="text"
           name="nama_barang"
           placeholder="Nama Barang">

    <br><br>

    <select name="kategori_id">

        @foreach ($kategori as $item)

            <option value="{{ $item->id }}">
                {{ $item->kategori }}
            </option>

        @endforeach

    </select>

    <br><br>

    <input type="number"
           name="harga"
           placeholder="Harga">

    <br><br>

    <input type="text"
           name="gambar"
           placeholder="Nama Gambar">

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>