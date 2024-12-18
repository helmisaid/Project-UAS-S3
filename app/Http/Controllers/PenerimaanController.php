<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenerimaanController extends Controller
{
    public function create($idPengadaan)
    {
        $user = Auth::user();

        // Mendapatkan menu berdasarkan jenis karyawan
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();


        // Ambil data barang pengadaan
        $barangPengadaan = DB::table('detail_pengadaan as dp')
            ->leftJoin('detail_penerimaan as dpr', function ($join) use ($idPengadaan) {
                $join->on('dp.idbarang', '=', 'dpr.barang_idbarang')
                    ->leftJoin('penerimaan as p', 'dpr.idpenerimaan', '=', 'p.idpenerimaan')
                    ->where('p.idpengadaan', '=', $idPengadaan);
            })
            ->join('barang as b', 'dp.idbarang', '=', 'b.idbarang')
            ->where('dp.idpengadaan', $idPengadaan)
            ->select(
                'dp.idbarang',
                'b.nama as nama_barang',
                'dp.jumlah as jumlah_pesan',
                'b.harga',
                DB::raw("COALESCE(SUM(CASE WHEN p.idpengadaan = $idPengadaan THEN dpr.jumlah_terima ELSE 0 END), 0) as total_terima")
            )
            ->groupBy('dp.idbarang', 'b.nama', 'dp.jumlah', 'b.harga')
            ->get();

        // Hitung kolom sisa untuk setiap barang
        foreach ($barangPengadaan as &$barang) {
            $barang->sisa = $barang->jumlah_pesan - $barang->total_terima;
        }

        // Ambil history penerimaan
        $historyPenerimaan = DB::table('penerimaan as p')
            ->join('detail_penerimaan as dp', 'p.idpenerimaan', '=', 'dp.idpenerimaan')
            ->join('barang as b', 'dp.barang_idbarang', '=', 'b.idbarang')
            ->where('p.idpengadaan', $idPengadaan)
            ->select(
                'p.idpenerimaan',
                'p.created_at',
                'dp.barang_idbarang',
                'b.nama as nama_barang',
                'dp.jumlah_terima',
                'dp.harga_satuan_terima',
                'dp.sub_total_terima'
            )
            ->orderBy('p.created_at', 'DESC')
            ->get();

        return view('penerimaan.create', compact('barangPengadaan', 'idPengadaan', 'historyPenerimaan', 'menus'));
    }

    public function store(Request $request)
{
    $idPengadaan = $request->input('id_pengadaan');
    $items = $request->input('barang'); // Mengambil input array 'barang'

    // Validasi input array
    if (!is_array($items) || empty($items)) {
        return redirect()->back()->withErrors(['error' => 'Tidak ada data barang yang diterima.']);
    }

    $idPenerimaan = null;

    foreach ($items as $idBarang => $item) {
        if (!isset($item['terima'])) {
            continue; // Skip barang yang tidak dicentang
        }

        $jumlahTerima = (int)($item['jumlah_terima'] ?? 0);
        $hargaSatuan = (int)($item['harga_satuan'] ?? 0);

        // Ambil data barang dari database
        $barangPengadaan = DB::table('detail_pengadaan as dp')
            ->leftJoin('detail_penerimaan as dpr', function ($join) use ($idPengadaan) {
                $join->on('dp.idbarang', '=', 'dpr.barang_idbarang')
                    ->whereIn('dpr.idpenerimaan', function ($query) use ($idPengadaan) {
                        $query->select('p.idpenerimaan')
                            ->from('penerimaan as p')
                            ->where('p.idpengadaan', '=', $idPengadaan);
                    });
            })
            ->where('dp.idbarang', $idBarang)
            ->where('dp.idpengadaan', $idPengadaan)
            ->select('dp.idbarang', 'dp.jumlah as jumlah_pesan', DB::raw('COALESCE(SUM(dpr.jumlah_terima), 0) as total_terima'))
            ->groupBy('dp.idbarang', 'dp.jumlah')
            ->first();

        if (!$barangPengadaan) {
            return redirect()->back()->withErrors(['error' => 'Barang tidak ditemukan dalam pengadaan.']);
        }

        $sisa = $barangPengadaan->jumlah_pesan - $barangPengadaan->total_terima;

        // Validasi jumlah terima
        if ($jumlahTerima > $sisa || $jumlahTerima <= 0) {
            return redirect()->back()->withErrors(['error' => 'Jumlah terima tidak valid untuk barang ID ' . $idBarang]);
        }

        // Insert ke tabel penerimaan jika belum ada
        if (!$idPenerimaan) {
            $idPenerimaan = DB::table('penerimaan')->insertGetId([
                'created_at' => now(),
                'status' => '1',
                'idpengadaan' => $idPengadaan,
                'id_karyawan' => Auth::id()
            ]);
        }

        // Insert detail penerimaan
        DB::table('detail_penerimaan')->insert([
            'idpenerimaan' => $idPenerimaan,
            'barang_idbarang' => $idBarang,
            'jumlah_terima' => $jumlahTerima,
            'harga_satuan_terima' => $hargaSatuan,
            'sub_total_terima' => $jumlahTerima * $hargaSatuan
        ]);
    }

    // Update status pengadaan jika semua barang telah diterima
    // Update status pengadaan jika semua barang telah diterima
        $totalBarang = DB::table('detail_pengadaan as dp')
        ->leftJoin('detail_penerimaan as dpr', function ($join) use ($idPengadaan) {
            $join->on('dp.idbarang', '=', 'dpr.barang_idbarang')
                ->whereIn('dpr.idpenerimaan', function ($query) use ($idPengadaan) {
                    $query->select('p.idpenerimaan')
                        ->from('penerimaan as p')
                        ->where('p.idpengadaan', '=', $idPengadaan);
                });
        })
        ->where('dp.idpengadaan', $idPengadaan)
        ->select(
            DB::raw("(SELECT SUM(jumlah) FROM detail_pengadaan WHERE idpengadaan = $idPengadaan) as total_pesan"),
            DB::raw('COALESCE(SUM(dpr.jumlah_terima), 0) as total_diterima')
        )
        ->first();


    if ($totalBarang->total_pesan == $totalBarang->total_diterima) {
        DB::table('pengadaan')->where('idpengadaan', $idPengadaan)->update(['status' => 1]);
    }

    return redirect()->back()->with('success', 'Penerimaan berhasil ditambahkan.');
}

}
