<h1>Edit Kategori</h1>

<form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text"
           name="kategori"
           value="{{ $kategori->kategori }}">

    <button type="submit">
        Update
    </button>
</form>