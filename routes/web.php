<?php

use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\PenarikanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PermintaanPinjamanController;
use App\Http\Controllers\Admin\PinjamanController;
use App\Http\Controllers\Admin\TabunganController;
use App\Http\Controllers\Anggota\AngsuranPinjamanController;
use App\Http\Controllers\Anggota\MutasiAnggotaController;
use App\Http\Controllers\Anggota\PengajuanPinjamanController;
use App\Http\Controllers\Anggota\SetoranTabunganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function() {

    Route::middleware(['role:1'])->group(function() {
        Route::resource('anggota', AnggotaController::class)->parameter('anggota', 'anggota');
        Route::resource('penarikan', PenarikanController::class)->parameter('penarikan', 'penarikan');
        Route::resource('permintaan-pinjaman', PermintaanPinjamanController::class)->parameter('permintaan-pinjaman', 'pinjaman');

        Route::resource('pinjaman', PinjamanController::class)->parameter('pinjaman', 'pinjaman');
        Route::get('pinjaman-tagihan/{pinjaman}', [PinjamanController::class, 'tagihan'])->name('pinjaman.tagihan');

        Route::resource('tabungan', TabunganController::class)->parameter('tabungan', 'tabungan');
        Route::get('tabungan-tagihan', [TabunganController::class, 'tagihan'])->name('tabungan.tagihan');
    
        Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('pengaturan/{id}', [PengaturanController::class, 'update'])->name('pengaturan.update');
    });

    Route::middleware(['role:2'])->group(function(){
        Route::resource('pengajuan-pinjaman', PengajuanPinjamanController::class)->parameter('pengajuan-pinjaman', 'pinjaman');
        Route::get('pengajuan-pinjaman-tagihan/{pinjaman}', [PengajuanPinjamanController::class, 'tagihan'])->name('pengajuan-pinjaman.tagihan');

        Route::resource('mutasi-anggota', MutasiAnggotaController::class)->parameter('mutasi-anggota', 'tabungan');
        Route::resource('setoran-tabungan', SetoranTabunganController::class)->parameter('setoran-tabungan', 'tabungan');
    });
});

require __DIR__.'/auth.php';
