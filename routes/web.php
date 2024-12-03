<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\LayananController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::get('karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
Route::post('karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::get('karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
Route::put('karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
Route::delete('karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');


Route::get('layanan', [LayananController::class, 'index'])->name('layanan.index');
Route::get('layanan/create', [LayananController::class, 'create'])->name('layanan.create');
Route::post('layanan', [LayananController::class, 'store'])->name('layanan.store');
Route::get('layanan/{id_layanan}/edit', [LayananController::class, 'edit'])->name('layanan.edit');
Route::put('layanan/{id_layanan}', [LayananController::class, 'update'])->name('layanan.update');
Route::delete('layanan/{id_layanan}', [LayananController::class, 'destroy'])->name('layanan.destroy');




Route::resource('satuan', SatuanController::class);
