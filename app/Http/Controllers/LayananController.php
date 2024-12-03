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
        // Validasi data yang diterima
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'status' => 'required|boolean',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan', // Validasi ID Karyawan
        ]);

        // Simpan layanan baru
        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'status' => $request->status,
            'id_karyawan' => $request->id_karyawan, // Simpan ID Karyawan
        ]);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil layanan yang akan diedit beserta data karyawan
        $layanan = Layanan::findOrFail($id);
        $karyawans = Karyawan::all(); // Ambil semua karyawan
        return view('layanan.edit', compact('layanan', 'karyawans'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'status' => 'required|boolean',
            'id_karyawan' => 'required|exists:karyawan,id_karyawan', // Validasi ID Karyawan
        ]);

        // Cari layanan berdasarkan ID
        $layanan = Layanan::findOrFail($id);

        // Update data layanan
        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'status' => $request->status,
            'id_karyawan' => $request->id_karyawan, // Update ID Karyawan
        ]);

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Cari dan hapus layanan berdasarkan ID
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
