<h1>Tambah Kategori</h1>

<form action="{{ route('kategori.store') }}" method="POST">
    @csrf

    <input type="text" name="kategori" placeholder="Masukkan Nama Kategori">

    <button type="submit">
        Simpan
    </button>
</form>