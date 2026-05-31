@extends('layouts.yumna')

@section('body-class', 'page-yumna page-barang')

@section('title', 'Edit Barang — Yumna')

@section('content')
@endsection

@push('scripts')
<script>
    window.location.replace(@json(route('barang.index')));
</script>
@endpush
