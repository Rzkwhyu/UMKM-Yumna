@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<h1>Data Kategori</h1>

<a href="{{ route('kategori.create') }}">
    Tambah Kategori
</a>

<hr>

@foreach ($kategori as $item)
    <p>
        {{ $item->kategori }}

        <a href="{{ route('kategori.edit', $item->id) }}">
            Edit
        </a>

        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit">
                Hapus
            </button>
        </form>
    </p>
@endforeach