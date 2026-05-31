@extends('layouts.yumna')

@section('body-class', 'page-yumna page-profile-password')

@section('title', 'Change Password — Yumna')

@section('hide-hero', '1')

@push('styles')
    @include('partials.profile-page-styles')
@endpush

@section('content')
<div class="profile-shell">
    <div class="profile-topbar">
        <a href="{{ route('profile.index') }}" class="profile-back" aria-label="Kembali">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h2>Change Password</h2>
        <button type="submit" form="passwordForm" class="profile-topbar-action" title="Simpan">
            <i class="fa-solid fa-check"></i>
        </button>
    </div>

    <form
        id="passwordForm"
        method="POST"
        action="{{ route('profile.password.update') }}"
        class="profile-body"
    >
        @csrf
        @method('PUT')

        <div class="profile-form-group">
            <label for="current_password" class="visually-hidden">Password lama</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
                placeholder="password"
                autocomplete="current-password"
            >
            @error('current_password')
                <div class="profile-form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="password" class="visually-hidden">Password baru</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="new password"
                autocomplete="new-password"
            >
            @error('password')
                <div class="profile-form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="password_confirmation" class="visually-hidden">Konfirmasi password</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="confirm new password"
                autocomplete="new-password"
            >
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .visually-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }
</style>
@endpush
