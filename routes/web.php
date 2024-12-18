<?php

use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\MenuLevelController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\JenisKaryawanController;
use App\Http\Controllers\MarginPenjualanController;
use App\Http\Controllers\SettingMenuUserController;


Route::get('/', function () {
    return redirect('/login');
});


Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('karyawan', [KaryawanController::class, 'index'])->name('karyawan.index')->middleware('auth');
Route::get('karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create')->middleware('auth');
Route::post('karyawan', [KaryawanController::class, 'store'])->name('karyawan.store')->middleware('auth');
Route::get('karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit')->middleware('auth');
Route::put('karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update')->middleware('auth');
Route::delete('karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy')->middleware('auth');


Route::get('layanan', [LayananController::class, 'index'])->name('layanan.index')->middleware('auth');
Route::get('layanan/create', [LayananController::class, 'create'])->name('layanan.create')->middleware('auth');
Route::post('layanan', [LayananController::class, 'store'])->name('layanan.store')->middleware('auth');
Route::get('layanan/{id_layanan}/edit', [LayananController::class, 'edit'])->name('layanan.edit')->middleware('auth');
Route::put('layanan/{id_layanan}', [LayananController::class, 'update'])->name('layanan.update')->middleware('auth');
Route::delete('layanan/{id_layanan}', [LayananController::class, 'destroy'])->name('layanan.destroy')->middleware('auth');


Route::resource('satuan', SatuanController::class)->middleware('auth');


// Route::resource('barang', BarangController::class)->middleware('auth');

// Rute untuk CRUD Barang
Route::get('barang', [BarangController::class, 'index'])->name('barang.index')->middleware('auth');
Route::get('barang/create', [BarangController::class, 'create'])->name('barang.create')->middleware('auth');
Route::post('barang', [BarangController::class, 'store'])->name('barang.store')->middleware('auth');
Route::get('barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit')->middleware('auth');
Route::put('barang/{id}', [BarangController::class, 'update'])->name('barang.update')->middleware('auth');
Route::delete('barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy')->middleware('auth');


Route::resource('vendor', VendorController::class)->middleware('auth');

Route::resource('jeniskaryawan', JenisKaryawanController::class)->middleware('auth');

// route autentikasi
Route::get('/login', [AuthController::class, 'indexlogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'actionlogout'])->name('logout');

Route::prefix('menu-levels')->middleware(['auth', isAdmin::class])->name('menu-levels.')->group(function () {
    Route::get('/', [MenuLevelController::class, 'index'])->name('index');
    Route::get('/create', [MenuLevelController::class, 'create'])->name('create');
    Route::post('/', [MenuLevelController::class, 'store'])->name('store');
    Route::get('/{menuLevel}/edit', [MenuLevelController::class, 'edit'])->name('edit');
    Route::put('/{menuLevel}', [MenuLevelController::class, 'update'])->name('update');
    Route::delete('/{menuLevel}', [MenuLevelController::class, 'destroy'])->name('destroy');
});

Route::prefix('menus')->middleware(['auth', isAdmin::class])->name('menus.')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('index');
    Route::get('/create', [MenuController::class, 'create'])->name('create');
    Route::post('/', [MenuController::class, 'store'])->name('store');
    Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
    Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
    Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
});

Route::prefix('settingmenuuser')->middleware(['auth', isAdmin::class])->name('settingmenuuser.')->group(function () {
    Route::get('/', [SettingMenuUserController::class, 'index'])->name('index');
    Route::get('/create', [SettingMenuUserController::class, 'create'])->name('create');
    Route::post('/', [SettingMenuUserController::class, 'store'])->name('store');
    Route::get('/{settingMenuUser}/edit', [SettingMenuUserController::class, 'edit'])->name('edit');
    Route::put('/{settingMenuUser}', [SettingMenuUserController::class, 'update'])->name('update');
    Route::delete('/{settingMenuUser}', [SettingMenuUserController::class, 'destroy'])->name('destroy');
});

Route::resource('margin_penjualan', MarginPenjualanController::class);

Route::resource('pengadaan', PengadaanController::class);
Route::get('/pengadaan/detail/{idPengadaan}', [PengadaanController::class, 'detail']);
Route::resource('penjualan', PenjualanController::class);
Route::post('/kasir', [PenjualanController::class, 'kasir'])->name('kasir.store');

Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan.index');
Route::get('/penerimaan/create/{idpengadaan}', [PenerimaanController::class, 'create'])->name('penerimaan.create');
Route::post('/penerimaan/store', [PenerimaanController::class, 'store'])->name('penerimaan.store');

Route::get('/kartu-stok', [BarangController::class, 'kartustok'])->name('kartustok.index');
Route::get('/kartu-stok/{idbarang}', [BarangController::class, 'detail'])->name('kartustok.detail');

Route::get('/retur', [ReturController::class, 'index'])->name('retur.index');
Route::post('/retur/load-detail', [ReturController::class, 'loadDetail'])->name('retur.loadDetail');
Route::post('/retur/store', [ReturController::class, 'store'])->name('retur.store');

// Kasir routes
Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');

use App\Http\Controllers\ReportController;

Route::prefix('reports')->group(function () {
    Route::get('/sales', [ReportController::class, 'showSalesReport'])->name('reports.sales');
    Route::get('/profit', [ReportController::class, 'profitReport'])->name('reports.profit');
    Route::get('/inventory', [ReportController::class, 'inventoryReport'])->name('reports.inventory');
    Route::get('/generate-pdf/{reportType}', [ReportController::class, 'generatePDF'])->name('reports.pdf');
});

Route::middleware('auth')->group(function () {
    Route::get('/myjob', [ServiceController::class, 'listjob'])->name('service.job');
    Route::put('service/{id}/update-status', [ServiceController::class, 'updateStatus'])->name('service.updateStatus');
});
