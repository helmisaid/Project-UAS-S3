<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    /**
     * Menampilkan daftar satuan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $satuan = Satuan::all(); // Ambil semua data satuan
        return view('satuan.index', compact('satuan', 'menus'));
    }

    /**
     * Menampilkan form untuk membuat satuan baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        return view('satuan.create', compact('menus'));
    }

    /**
     * Menyimpan satuan baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
            'status' => 'required|boolean', // Pastikan status adalah boolean (1 atau 0)
        ]);

        // Simpan data satuan ke dalam database
        Satuan::create([
            'nama_satuan' => $request->nama_satuan,
            'status' => $request->status,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit satuan.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        // Ambil data satuan berdasarkan ID
        $satuan = Satuan::findOrFail($id);
        return view('satuan.edit', compact('satuan', 'menus'));
    }

    /**
     * Mengupdate data satuan dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
            'status' => 'required|boolean', // Pastikan status adalah boolean (1 atau 0)
        ]);

        // Cari satuan berdasarkan ID
        $satuan = Satuan::findOrFail($id);

        // Update data satuan
        $satuan->update([
            'nama_satuan' => $request->nama_satuan,
            'status' => $request->status,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil diperbarui.');
    }

    /**
     * Menghapus data satuan dari database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Cari satuan berdasarkan ID
        $satuan = Satuan::findOrFail($id);

        // Hapus data satuan
        $satuan->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil dihapus.');
    }
}
