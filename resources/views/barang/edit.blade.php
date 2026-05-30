<h1>Edit Barang</h1>

<form action="{{ route('barang.update', $barang->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <input type="text"
           name="nama_barang"
           value="{{ $barang->nama_barang }}">

    <br><br>

    <select name="kategori_id">

        @foreach ($kategori as $item)

            <option value="{{ $item->id }}"
                {{ $barang->kategori_id == $item->id ? 'selected' : '' }}>

                {{ $item->kategori }}

            </option>

        @endforeach

    </select>

    <br><br>

    <input type="number"
           name="harga"
           value="{{ $barang->harga }}">

    <br><br>

    <input type="text"
           name="gambar"
           value="{{ $barang->gambar }}">

    <br><br>

    <button type="submit">
        Update
    </button>

</form>