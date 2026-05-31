@extends('layouts.yumna')

@section('body-class', 'page-yumna page-profile-edit')

@section('title', 'Edit Profile — Yumna')

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
        <h2>Edit Profile</h2>
    </div>

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
        class="profile-body"
    >
        @csrf
        @method('PUT')

        <div class="profile-photo-edit">
            <img
                id="profilePhotoPreview"
                src="{{ $user->avatar_url }}"
                alt="{{ $user->name }}"
            >
            <label class="profile-change-photo">
                Change Photo Profile
                <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/gif,image/webp">
            </label>
            @error('avatar')
                <div class="profile-form-error" style="margin-top:8px">{{ $message }}</div>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username', $user->username) }}"
                placeholder="bravestar71"
                autocomplete="username"
            >
            @error('username')
                <div class="profile-form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="name">Name</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                autocomplete="name"
            >
            @error('name')
                <div class="profile-form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                autocomplete="email"
            >
            @error('email')
                <div class="profile-form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="profile-form-group">
            <label for="address">Address</label>
            <textarea
                id="address"
                name="address"
                placeholder="Alamat lengkap"
            >{{ old('address', $user->address) }}</textarea>
            @error('address')
                <div class="profile-form-error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-profile-primary">Save</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('avatarInput');
        const preview = document.getElementById('profilePhotoPreview');

        if (!input || !preview) return;

        input.addEventListener('change', function () {
            const file = input.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
