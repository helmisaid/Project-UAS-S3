<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Mendapatkan menu berdasarkan jenis karyawan
    $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
        $query->select('menu_id')
            ->from('setting_menu_user')
            ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
    })->orderBy('parent_id')->get();


    $barangs = DB::table('barang')
        ->leftJoin('margin_penjualan', 'margin_penjualan.status', '=', DB::raw('1'))
        ->select(
            'barang.idbarang',
            'barang.nama',
            'barang.harga AS harga_asli',
            DB::raw('IFNULL(barang.harga + (barang.harga * (margin_penjualan.persen / 100)), barang.harga) AS harga')
        )
        ->get();

    $layanans = DB::table('layanan')->get();


    return view('penjualan.index', compact('barangs', 'layanans', 'menus'));
}

public function store(Request $request)
{
    $items = $request->input('items');
    $userId = Auth::id();

    $subtotal = collect($items)->sum(fn($item) => $item['harga'] * $item['jumlah']);

    $idMarginPenjualan = DB::table('margin_penjualan')
        ->where('status', 1)
        ->orderByDesc('idmargin_penjualan')
        ->value('idmargin_penjualan');

    if (!$idMarginPenjualan) {
        return redirect()->route('penjualan.index')->with('error', 'Tidak ada margin penjualan yang aktif.');
    }

    $paymentAmount = $request->input('payment', 0);
    $discountPercentage = $request->input('discount', 0);
    $discountAmount = $subtotal * ($discountPercentage / 100);
    $ppnPercentage = $request->input('ppn', 0);
    $ppntotal = $subtotal * ($ppnPercentage / 100);
    $total = $subtotal + $ppntotal - $discountAmount;

    if ($paymentAmount < $total) {
        return redirect()->route('penjualan.index')->with('error', 'Jumlah pembayaran kurang dari total.');
    }

    foreach ($items as $item) {
        $stok = DB::selectOne("SELECT GetLatestStock(?) AS stok", [$item['idbarang']])->stok;

        if (!$stok || $stok < $item['jumlah']) {
            return redirect()->route('penjualan.index')->with('error', 'Stok barang tidak mencukupi.');
        }
    }

    $penjualanId = DB::table('penjualan')->insertGetId([
        'id_karyawan' => $userId,
        'subtotal_nilai' => $subtotal,
        'ppn' => $ppntotal,
        'total_nilai' => $total,
        'disc' => $discountAmount,
        'jumlah_bayar' => $paymentAmount,
        'idmargin_penjualan' => $idMarginPenjualan,
        'created_at' => now()
    ]);

    $detailPenjualan = collect($items)->map(fn($item) => [
        'penjualan_idpenjualan' => $penjualanId,
        'barang_idbarang' => $item['idbarang'],
        'harga_satuan' => $item['harga'],
        'jumlah' => $item['jumlah'],
        'subtotal' => $item['harga'] * $item['jumlah']
    ])->toArray();

    DB::table('detail_penjualan')->insert($detailPenjualan);

    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan');
}

}
