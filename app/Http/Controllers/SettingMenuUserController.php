<?php

namespace App\Http\Controllers;

use App\Models\JenisKaryawan;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\SettingMenuUser;
use Illuminate\Support\Facades\Auth;

class SettingMenuUserController extends Controller
{

    public function index()
    {
        $user = Auth::user(); // Get the currently logged-in user
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $settings = SettingMenuUser::with('jenisKaryawan', 'menu')->get();

        return view('settingsmenu.index', compact('settings', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $JenisKaryawan = JenisKaryawan::all();
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $datamenus = Menu::all();
        // Menampilkan form untuk menambah data baru
        return view('settingsmenu.create', compact('JenisKaryawan', 'menus', 'datamenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'id_jenis_karyawan' => 'required|exists:jenis_karyawan,id_jenis_karyawan',
            'menu_id' => 'required|exists:menu,menu_id',
            'created_by' => 'required|string|max:30',
        ]);

        // Simpan data ke dalam database
        $setting = SettingMenuUser::create([
            'id_jenis_karyawan' => $request->id_jenis_karyawan,
            'menu_id' => $request->menu_id,
            'created_by' => $request->created_by,
        ]);


        // Redirect dengan pesan sukses
        return redirect()->route('settingmenuuser.index')->with('success', 'Setting menu berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(SettingMenuUser $settingMenuUser)
    // {
    //     // Menampilkan detail dari setting menu user tertentu
    //     return view('settingmenuuser.show', compact('settingMenuUser'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SettingMenuUser $settingMenuUser)
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();
        $jenisKaryawan = JenisKaryawan::all();

        $datamenus = Menu::all();
        return view('settingsmenu.edit', compact('settingMenuUser', 'jenisKaryawan', 'menus', 'datamenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SettingMenuUser $settingMenuUser)
{
    // Validasi data input
    $request->validate([
        'id_jenis_karyawan' => 'required|exists:jenis_karyawan,id_jenis_karyawan',
        'menu_id' => 'required|exists:menu,menu_id',
        'created_by' => 'required|string|max:30',
    ]);

    // Update data ke dalam database
    $settingMenuUser->update([
        'id_jenis_karyawan' => $request->id_jenis_karyawan,
        'menu_id' => $request->menu_id,
        'created_by' => $request->created_by,  // Pastikan ini diperbolehkan di form dan diupdate
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('settingmenuuser.index')->with('success', 'Setting menu berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($no_setting)
    {
        $menu = SettingMenuUser::findOrFail($no_setting);
        $menu->delete();
        return redirect()->route('settingmenuuser.index')->with('success', 'Setting menu berhasil dihapus.');
    }
}
