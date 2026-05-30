@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<h1>Data Suplier</h1>

<a href="{{ route('suplier.create') }}">
    Tambah Suplier
</a>

<hr>

@foreach ($suplier as $item)

    <p>
        {{ $item->nama_pt }}
        |
        {{ $item->no_telp }}
        |
        {{ $item->logo }}

        <a href="{{ route('suplier.edit', $item->id) }}">
            Edit
        </a>

        <form action="{{ route('suplier.destroy', $item->id) }}"
              method="POST">

            @csrf
            @method('DELETE')

            <button type="submit">
                Hapus
            </button>

        </form>

    </p>

@endforeach