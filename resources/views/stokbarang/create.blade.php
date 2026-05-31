@extends('layouts.yumna')

@section('body-class', 'page-yumna page-stokbarang')

@section('title', 'Tambah Barang Masuk — Yumna')

@section('content')
<script>
    window.location.replace(@json(route('stokbarang.index', ['modal' => 'tambah'])));
</script>
@endsection
