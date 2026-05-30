@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<h1>Data Barang</h1>

<a href="{{ route('barang.create') }}">
    Tambah Barang
</a>

<hr>

@foreach ($barang as $item)

    <p>
        {{ $item->nama_barang }}
        |
        {{ $item->kategori->kategori }}
        |
        Stok : {{ $item->stok }}
        |
        Rp. {{ $item->harga }}

        <a href="{{ route('barang.edit', $item->id) }}">
            Edit
        </a>

        <form action="{{ route('barang.destroy', $item->id) }}"
              method="POST">

            @csrf
            @method('DELETE')

            <button type="submit">
                Hapus
            </button>

        </form>

    </p>

@endforeach