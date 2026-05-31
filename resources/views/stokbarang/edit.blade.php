@extends('layouts.yumna')

@section('body-class', 'page-yumna page-stokbarang')

@section('title', 'Edit Barang Masuk — Yumna')

@section('content')
<script>
    window.location.replace(@json(route('stokbarang.index', ['modal' => 'edit', 'id' => $stokbarang->id])));
</script>
@endsection
