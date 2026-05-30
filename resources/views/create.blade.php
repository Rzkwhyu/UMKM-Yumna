<h1>Tambah Suplier</h1>

<form action="{{ route('suplier.store') }}" method="POST">
    @csrf

    <input type="text"
           name="nama_pt"
           placeholder="Nama PT">

    <br><br>

    <input type="text"
           name="no_telp"
           placeholder="No Telp">

    <br><br>

    <input type="text"
           name="logo"
           placeholder="Logo">

    <br><br>

    <button type="submit">
        Simpan
    </button>

</form>