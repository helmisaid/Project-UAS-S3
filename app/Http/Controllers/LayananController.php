<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        // Ambil data layanan dengan relasi karyawan
        $layanan = Layanan::with('karyawan')->get();
        return view('layanan.index', compact('layanan'));
    }

    public function create()
    {
        // Ambil daftar karyawan yang ada
        $karyawans = Karyawan::all();
        return view('layanan.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|numeric',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        ]);
    
    
        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'harga_layanan' => $request->harga_layanan,
            'id_karyawan' => $request->id_karyawan,
        ]);
    
        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }
    
    
    public function edit($id_layanan)
    {
        // Ambil layanan yang akan diedit beserta data karyawan
        $layanan = Layanan::findOrFail($id_layanan);
        $karyawans = Karyawan::all(); // Ambil semua karyawan
        return view('layanan.edit', compact('layanan', 'karyawans'));
    }

    public function update(Request $request, $id_layanan)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga_layanan' => 'required|numeric',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
        ]);
    
        $layanan = Layanan::findOrFail($id_layanan);
        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'harga_layanan' => $request->harga_layanan,
            'id_karyawan' => $request->id_karyawan,
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
