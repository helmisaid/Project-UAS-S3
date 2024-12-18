<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Layanan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        // Ambil data layanan dengan relasi karyawan
        $layanan = Layanan::all();
        return view('layanan.index', compact('layanan', 'menus'));
    }

    public function create()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        // Ambil daftar karyawan yang ada
        $karyawans = Karyawan::all();
        return view('layanan.create', compact('karyawans', 'menus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|numeric',
        ]);


        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga_layanan' => $request->harga_layanan,
        ]);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }


    public function edit($id_layanan)
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        // Ambil layanan yang akan diedit beserta data karyawan
        $layanan = Layanan::findOrFail($id_layanan);
        $karyawans = Karyawan::all(); // Ambil semua karyawan
        return view('layanan.edit', compact('layanan', 'karyawans', 'menus'));
    }

    public function update(Request $request, $id_layanan)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|numeric',
        ]);

        $layanan = Layanan::findOrFail($id_layanan);
        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'harga_layanan' => $request->harga_layanan,

        ]);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }


    public function destroy($id_layanan)
    {
        // Cari dan hapus layanan berdasarkan ID
        $layanan = Layanan::findOrFail($id_layanan);
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
