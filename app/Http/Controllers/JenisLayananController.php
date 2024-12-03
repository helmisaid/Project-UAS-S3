<?php

namespace App\Http\Controllers;

use App\Models\JenisLayanan;
use Illuminate\Http\Request;

class JenisLayananController extends Controller
{
    public function index()
    {
        $jenisLayanan = JenisLayanan::all();
        return view('jenis-layanan.index', compact('jenisLayanan'));
    }

    public function create()
    {
        return view('jenis-layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
        ]);

        JenisLayanan::create($request->all());

        return redirect()->route('jenis-layanan.index')->with('success', 'Jenis Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenisLayanan = JenisLayanan::findOrFail($id);
        return view('jenis-layanan.edit', compact('jenisLayanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
        ]);

        $jenisLayanan = JenisLayanan::findOrFail($id);
        $jenisLayanan->update($request->all());

        return redirect()->route('jenis-layanan.index')->with('success', 'Jenis Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisLayanan = JenisLayanan::findOrFail($id);
        $jenisLayanan->delete();

        return redirect()->route('jenis-layanan.index')->with('success', 'Jenis Layanan berhasil dihapus.');
    }
}
