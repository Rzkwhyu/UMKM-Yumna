<h1>Edit Suplier</h1>

<form action="{{ route('suplier.update', $suplier->id) }}"
      method="POST">

    @csrf
    @method('PUT')

    <input type="text"
           name="nama_pt"
           value="{{ $suplier->nama_pt }}">

    <br><br>

    <input type="text"
           name="no_telp"
           value="{{ $suplier->no_telp }}">

    <br><br>

    <input type="text"
           name="logo"
           value="{{ $suplier->logo }}">

    <br><br>

    <button type="submit">
        Update
    </button>

</form>