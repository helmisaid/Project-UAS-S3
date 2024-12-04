<?php

namespace App\Http\Controllers;

use App\Models\JenisKaryawan;
use Illuminate\Http\Request;

class JenisKaryawanController extends Controller
{
    public function index()
    {
        $jenisKaryawan = JenisKaryawan::all();
        return view('jeniskaryawan.index', compact('jenisKaryawan'));
    }

    public function create()
    {
        return view('jeniskaryawan.create');
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
        $jenisKaryawan = JenisKaryawan::findOrFail($id);
        return view('jeniskaryawan.edit', compact('jenisKaryawan'));
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
