<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\MarginPenjualan;
use Illuminate\Support\Facades\Auth;

class MarginPenjualanController extends Controller
{
    // Menampilkan daftar margin penjualan
    public function index()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $margins = MarginPenjualan::with('karyawan')->get();
        return view('margin_penjualan.index', compact('margins', 'menus'));
    }

    // Menampilkan form untuk menambah margin penjualan
    public function create()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        return view('margin_penjualan.create', compact('menus'));
    }

    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'persen' => 'required|numeric',
        'status' => 'required|boolean',
        // Tidak perlu validasi id_karyawan, karena kita ambil dari user yang sedang login
    ]);

    // Ambil id_karyawan dari user yang sedang login
    $user = Auth::user();
    $request->merge(['id_karyawan' => $user->id_karyawan]);

    // Simpan data MarginPenjualan
    MarginPenjualan::create($request->all());

    return redirect()->route('margin_penjualan.index')->with('success', 'Margin Penjualan berhasil ditambahkan.');
}

// Menampilkan form untuk mengedit margin penjualan
public function edit($id)
{
    $user = Auth::user(); // Dapatkan user yang sedang login
    $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
        $query->select('menu_id')
            ->from('setting_menu_user')
            ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
    })->orderBy('parent_id')->get();

    $margin = MarginPenjualan::findOrFail($id);
    return view('margin_penjualan.edit', compact('margin', 'menus'));
}

public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'persen' => 'required|numeric',
        'status' => 'required|boolean',
        // Tidak perlu validasi id_karyawan, karena kita ambil dari user yang sedang login
    ]);

    // Ambil margin penjualan yang ingin diupdate
    $margin = MarginPenjualan::findOrFail($id);

    // Ambil id_karyawan dari user yang sedang login
    $user = Auth::user();
    $request->merge(['id_karyawan' => $user->id_karyawan]);

    // Update data MarginPenjualan
    $margin->update($request->all());

    return redirect()->route('margin_penjualan.index')->with('success', 'Margin Penjualan berhasil diperbarui.');
}

    // Di dalam controller MarginPenjualanController
public function destroy($id)
{
    // Cari data MarginPenjualan berdasarkan ID
    $margin = MarginPenjualan::findOrFail($id);

    // Hapus data MarginPenjualan
    $margin->delete();

    // Kembali ke halaman daftar dengan pesan sukses
    return redirect()->route('margin_penjualan.index')->with('success', 'Margin Penjualan berhasil dihapus.');
}

}
