@extends('layouts.yumna')

@section('body-class', 'page-yumna page-barang')

@section('title', 'Tambah Barang — Yumna')

@section('content')
@endsection

@push('scripts')
<script>
    window.location.replace(@json(route('barang.index', ['modal' => 'tambah'])));
</script>
@endpush
