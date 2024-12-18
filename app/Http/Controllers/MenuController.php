<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\ChildMenu;
use App\Models\MenuLevel;
use Illuminate\Http\Request;
use App\Models\TransaksiHarian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{

    public function index()
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();


        // return view('menus.index', compact('menus'));
        $datamenus = Menu::all();
        return view('menus.index', compact('datamenus', 'menus'));
    }

    public function create()
    {
        $menuLevels = MenuLevel::all();
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();
        $datamenus = Menu::all();
        return view('menus.create', compact('menuLevels', 'datamenus', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_name' => 'required|string|max:30',
            'menu_link' => 'required|string|max:50',
            'menu_icon' => 'required|string|max:30',
            'level_id' => 'required|string|max:30|exists:menu_level,level_id',
            'parent_id' => 'nullable|string|max:30|exists:menu,menu_id',
            'created_by' => 'required|string|max:10',
        ]);

        // Simpan data ke dalam database
        Menu::create([
            'menu_name' => $request->menu_name,
            'menu_link' => $request->menu_link,
            'menu_icon' => $request->menu_icon,
            'level_id' => $request->level_id,
            'parent_id' => $request->parent_id,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = Auth::user(); // Dapatkan user yang sedang login
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();
        $menu = Menu::findOrFail($id);
        $datamenus = Menu::all();
        $menuLevels = MenuLevel::all();

        // return view('menus.edit', compact('menu', 'menus', 'menuLevels'));
        return view('menus.edit', compact('menu', 'menuLevels', 'datamenus', 'menus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'menu_name' => 'required|string|max:30',
            'menu_link' => 'required|string|max:50',
            'menu_icon' => 'required|string|max:30',
            'level_id' => 'required|string|max:30|exists:menu_level,level_id',
            'parent_id' => 'nullable|string|max:30|exists:menu,menu_id',
            'created_by' => 'required|string|max:10',
        ]);

        // Temukan menu yang akan diperbarui
        $menu = Menu::findOrFail($id);

        // Update data menu berdasarkan input dari form
        $menu->update([
            'menu_name' => $request->menu_name,
            'menu_link' => $request->menu_link,
            'menu_icon' => $request->menu_icon,
            'level_id' => $request->level_id,
            'parent_id' => $request->parent_id,
            'created_by' => $request->created_by,
        ]);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }

}
