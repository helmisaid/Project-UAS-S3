<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $vendors = Vendor::all();
        return view('vendor.index', compact('vendors', 'menus'));
    }

    public function create()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        return view('vendor.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:100',
            'badan_hukum' => 'required|in:1,0', // Validasi CHAR(1) sebagai boolean
            'status' => 'required|in:1,0',
        ]);

        Vendor::create($request->all());
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $vendor = Vendor::findOrFail($id);
        return view('vendor.edit', compact('vendor', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_vendor' => 'required|string|max:100',
            'badan_hukum' => 'required|in:1,0',
            'status' => 'required|in:1,0',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        return redirect()->route('vendor.index')->with('success', 'Vendor berhasil dihapus.');
    }
}
