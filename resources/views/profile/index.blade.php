@extends('layouts.yumna')

@section('body-class', 'page-yumna page-profile')

@section('title', 'Profile — Yumna')

@section('hide-hero', '1')

@push('styles')
    @include('partials.profile-page-styles')
@endpush

@section('content')
<div class="profile-shell">
    <div class="profile-topbar">
        <a href="{{ route('home') }}" class="profile-back" aria-label="Kembali">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h2>Profile</h2>
    </div>

    @if (session('success'))
        <div class="profile-alert-success">{{ session('success') }}</div>
    @endif

    <div class="profile-body">
        <div class="profile-user-row">
            <img
                class="profile-avatar"
                src="{{ $user->avatar_url }}"
                alt="{{ $user->name }}"
            >
            <div>
                <div class="profile-username">{{ $user->display_username }}</div>
                <div class="profile-name">{{ $user->name }}</div>
            </div>
        </div>

        <h3 class="profile-section-title">Settings</h3>
        <ul class="profile-menu">
            <li>
                <a href="{{ route('profile.edit') }}">
                    Edit Profile
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.password') }}">
                    Change Password
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
            <li>
                <button type="button" class="menu-logout" id="btnLogoutOpen">
                    Log Out
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </li>
        </ul>
    </div>
</div>

<div class="profile-modal-overlay" id="logoutModal" role="dialog" aria-modal="true" aria-labelledby="logoutModalTitle">
    <div class="profile-modal">
        <p id="logoutModalTitle">Sudah yakin mau Logout?</p>
        <div class="profile-modal-actions">
            <form method="POST" action="{{ route('logout') }}" style="flex:1">
                @csrf
                <button type="submit" class="btn-profile-primary">Ya</button>
            </form>
            <button type="button" class="btn-profile-secondary" id="btnLogoutCancel">Tidak</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('logoutModal');
        const openBtn = document.getElementById('btnLogoutOpen');
        const cancelBtn = document.getElementById('btnLogoutCancel');

        if (!modal || !openBtn) return;

        openBtn.addEventListener('click', function () {
            modal.classList.add('is-open');
        });

        cancelBtn.addEventListener('click', function () {
            modal.classList.remove('is-open');
        });

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.remove('is-open');
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                modal.classList.remove('is-open');
            }
        });
    });
</script>
@endpush
