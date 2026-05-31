@extends('layouts.yumna')

@section('body-class', 'page-yumna page-suplier')

@section('title', 'Edit Supplier — Yumna')

@section('content')
@endsection

@push('scripts')
<script>
    window.location.replace(@json(route('suplier.index')));
</script>
@endpush
