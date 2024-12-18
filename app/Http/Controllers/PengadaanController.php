<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengadaanController extends Controller
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

    // Mengambil data pengadaan dengan join ke tabel vendor dan karyawan
    $pengadaans = DB::table('pengadaan as p')
        ->join('vendor as v', 'p.vendor_idvendor', '=', 'v.idvendor')
        ->join('karyawan as k', 'p.id_karyawan', '=', 'k.id_karyawan') // Sesuaikan nama kolom di tabel pengadaan
        ->select(
            'p.idpengadaan',
            'v.nama_vendor',
            'k.nama_karyawan as nama_user', // Disesuaikan dengan kolom tabel karyawan
            'p.subtotal_nilai',
            'p.ppn',
            'p.total_nilai',
            'p.status',
            'p.timestamp'
        )
        ->orderByDesc('p.idpengadaan')
        ->get();

    // Mengambil data vendor
    $vendors = DB::table('vendor')->get();

    // Mengambil data barang
    $barangs = DB::table('barang')->get();

    return view('pengadaan.index', compact('pengadaans', 'vendors', 'barangs', 'menus'));
}

public function store(Request $request)
{
    $vendorId = $request->input('vendor_id');
    $items = $request->input('items');
    $userId = Auth::id();

    $subtotal = collect($items)->sum(fn($item) => $item['harga'] * $item['jumlah']);

    $ppnPercentage = $request->input('ppn', 0);
    $ppn = $subtotal * ($ppnPercentage / 100);
    $total = $subtotal + $ppn;

    // Simpan data pengadaan
    $pengadaanId = DB::table('pengadaan')->insertGetId([
        'vendor_idvendor' => $vendorId,
        'id_karyawan' => $userId,
        'subtotal_nilai' => $subtotal,
        'ppn' => $ppn,
        'total_nilai' => $total,
        'status' => '0',
        'timestamp' => now(),
    ]);

    // Simpan detail pengadaan
    $detailData = collect($items)->map(fn($item) => [
        'idpengadaan' => $pengadaanId,
        'idbarang' => $item['idbarang'],
        'harga_satuan' => $item['harga'],
        'jumlah' => $item['jumlah'],
        'sub_total' => $item['harga'] * $item['jumlah'],
    ])->toArray();

    DB::table('detail_pengadaan')->insert($detailData);

    return redirect()->route('pengadaan.index')->with('success', 'Pengadaan berhasil ditambahkan');
}

public function detail($idPengadaan)
{
    $details = DB::table('detail_pengadaan as dp')
        ->join('barang as b', 'dp.idbarang', '=', 'b.idbarang')
        ->where('dp.idpengadaan', $idPengadaan)
        ->select(
            'b.nama as nama_barang',
            'dp.harga_satuan',
            'dp.jumlah',
            'dp.sub_total'
        )
        ->get();

    return response()->json($details);
}

}
