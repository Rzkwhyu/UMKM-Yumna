<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('kategori', KategoriController::class);
Route::resource('barang', BarangController::class);
Route::resource('suplier', SuplierController::class);
Route::resource('stokbarang', StokBarangController::class);
Route::get('transaksi/cetak-nota', [TransaksiController::class, 'cetakNota'])->name('transaksi.cetak-nota');
Route::resource('transaksi', TransaksiController::class);
Route::delete('transaksi/nota/hapus', [TransaksiController::class, 'destroyNota'])->name('transaksi.destroy-nota');
Route::get('laporan', [LaporanKeuanganController::class, 'index'])->name('laporan.index');

Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');