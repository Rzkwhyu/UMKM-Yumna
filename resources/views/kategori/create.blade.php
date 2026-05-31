@extends('layouts.yumna')

@section('body-class', 'page-yumna page-kategori')

@section('title', 'Tambah Kategori — Yumna')

@section('content')
@endsection

@push('scripts')
<script>
    window.location.replace(@json(route('kategori.index', ['modal' => 'tambah'])));
</script>
@endpush
