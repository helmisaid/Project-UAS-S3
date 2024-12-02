<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;


Route::get('/', function () {
    return view('dashboard');
});

Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::get('karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
Route::post('karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::get('karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
Route::put('karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
Route::delete('karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
