<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\JenisKaryawan;
use Illuminate\Support\Facades\Auth;

class JenisKaryawanController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $jenisKaryawan = JenisKaryawan::all();
        return view('jeniskaryawan.index', compact('jenisKaryawan', 'menus'));
    }

    public function create()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        return view('jeniskaryawan.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_karyawan' => 'required|string|max:255',
        ]);

        JenisKaryawan::create($request->all());
        return redirect()->route('jeniskaryawan.index')->with('success', 'Jenis Karyawan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $jenisKaryawan = JenisKaryawan::findOrFail($id);
        return view('jeniskaryawan.edit', compact('jenisKaryawan','menus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_karyawan' => 'required|string|max:255',
        ]);

        $jenisKaryawan = JenisKaryawan::findOrFail($id);
        $jenisKaryawan->update($request->all());
        return redirect()->route('jeniskaryawan.index')->with('success', 'Jenis Karyawan berhasil diubah');
    }

    public function destroy($id)
    {
        JenisKaryawan::findOrFail($id)->delete();
        return redirect()->route('jeniskaryawan.index')->with('success', 'Jenis Karyawan berhasil dihapus');
    }
}
