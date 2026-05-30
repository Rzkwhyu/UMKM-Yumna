@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<h1>Data Barang Masuk</h1>

<a href="{{ route('stokbarang.create') }}">
    Tambah Barang Masuk
</a>

<hr>

@foreach ($stokbarang as $item)

    <p>
        {{ $item->barang->nama_barang }}
        |
        {{ $item->tanggal_masuk }}
        |
        {{ $item->no_transaksi }}
        |
        {{ $item->suplier->nama_pt }}
        |
        Qty : {{ $item->qty }}

        <a href="{{ route('stokbarang.edit', $item->id) }}">
            Edit
        </a>

        <form action="{{ route('stokbarang.destroy', $item->id) }}"
              method="POST">

            @csrf
            @method('DELETE')

            <button type="submit">
                Hapus
            </button>

        </form>

    </p>

@endforeach