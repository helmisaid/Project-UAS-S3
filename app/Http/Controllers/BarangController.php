<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\KartuStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller

{
    public function index()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        // Ambil semua data barang dari database
        $barangs = Barang::all();
        $satuans = Satuan::all();
        // Tampilkan view index dengan data barang
        return view('barang.index', compact('barangs', 'menus', 'satuans'));
    }


      // Fungsi untuk menampilkan form tambah barang
        public function create()
        {
            $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $satuans = Satuan::all();
            return view('barang.create', compact('menus', 'satuans'));
        }

        public function edit($id)
        {
            $user = Auth::user(); // Dapatkan user yang sedang login
            $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
                $query->select('menu_id')
                    ->from('setting_menu_user')
                    ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
            })->orderBy('parent_id')->get();

            // Mencari data barang berdasarkan ID
            $barang = Barang::findOrFail($id);
            $satuans = Satuan::all();
            // Mengembalikan view dengan data barang
            return view('barang.edit', compact('barang', 'menus', 'satuans'));
        }

        public function destroy($id)
        {
            // Mencari data barang berdasarkan ID
            $barang = Barang::findOrFail($id);

            // Menghapus data barang
            $barang->delete();

            // Redirect kembali ke halaman daftar barang
            return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
        }

        public function store(Request $request)
        {
            // Validasi data
            $request->validate([
                'jenis' => 'required|string|max:30',
                'nama' => 'required|string|max:45',
                'idsatuan' => 'required|integer',
                'status' => 'required|boolean',
                'harga' => 'required|integer',
            ]);


    // Simpan data ke database
    Barang::create($request->all());

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
}

    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'jenis' => 'required|string|max:30',
            'nama' => 'required|string|max:45',
            'idsatuan' => 'required|exists:satuan,idsatuan',
            'status' => 'required|boolean',
            'harga' => 'required|numeric|min:0',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Update data
        $barang->update($validatedData);

        // Redirect atau beri respon
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }

    public function kartustok()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        // Get the latest stock for each item
        $latestStocks = KartuStok::select('idbarang')
            ->selectRaw('MAX(idkartu_stk) as latest_id')
            ->groupBy('idbarang');

        $currentStocks = KartuStok::join('barang', 'kartu_stok.idbarang', '=', 'barang.idbarang')
            ->joinSub($latestStocks, 'latest_stocks', function ($join) {
                $join->on('kartu_stok.idkartu_stk', '=', 'latest_stocks.latest_id')
                    ->on('kartu_stok.idbarang', '=', 'latest_stocks.idbarang');
            })
            ->select('kartu_stok.*', 'barang.nama as nama_barang')
            ->get();

        return view('barang.kartustok', compact('currentStocks', 'menus'));
    }

    public function detail($idbarang)
{
    $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

    $stockHistory = KartuStok::join('barang', 'kartu_stok.idbarang', '=', 'barang.idbarang')
        ->where('kartu_stok.idbarang', $idbarang)
        ->select('kartu_stok.*', 'barang.nama as nama_barang')
        ->orderBy('kartu_stok.created_at', 'desc')
        ->get();

    $barang = Barang::find($idbarang);

    return view('barang.kartustok-detail', compact('stockHistory', 'barang', 'menus'));
}

}
