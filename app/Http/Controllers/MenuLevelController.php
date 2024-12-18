<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuLevelController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the currently logged-in user
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

        $menuLevels = MenuLevel::all();


        return view('menulevel.index', compact('menuLevels', 'menus'));
    }

    public function create()
    {
        $user = Auth::user();
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();


        return view('menulevel.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required|string|max:30|unique:menu_level,level_id',
            'level' => 'required|string|max:60',
        ]);

        MenuLevel::create($request->all());
        return redirect()->route('menu-levels.index')->with('success', 'Menu level berhasil ditambahkan.');
    }

// Method untuk menampilkan form edit
public function edit($level_id)
{
    $user = Auth::user(); // Get the currently logged-in user
        $menus = Menu::whereIn('menu_id', function ($query) use ($user) {
            $query->select('menu_id')
                ->from('setting_menu_user')
                ->where('id_jenis_karyawan', $user->id_jenis_karyawan);
        })->orderBy('parent_id')->get();

    $menuLevel = MenuLevel::where('level_id', $level_id)->first();

    return view('menulevel.edit', compact('menuLevel', 'menus'));
}

public function update(Request $request, MenuLevel $menuLevel)
{
    $request->validate([
        'level_id' => 'required|string|max:30|unique:menu_level,level_id',
        'level' => 'required|string|max:60',
    ]);

    $menuLevel->level_id = $request->level_id;
    $menuLevel->level = $request->level;
    $menuLevel->save();
    return redirect()->route('menu-levels.index')->with('success', 'Menu level berhasil diperbarui.');
}

public function destroy($level_id)
{
    $menuLevel = Menu::findOrFail($level_id);
    $menuLevel->delete();
    return redirect()->route('menu-levels.index')->with('success', 'Menu level berhasil dihapus.');
}
}
