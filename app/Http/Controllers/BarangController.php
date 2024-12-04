<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller

{
    public function index()
    {
        // Ambil semua data barang dari database
        $barangs = Barang::all();
        
        // Tampilkan view index dengan data barang
        return view('barang.index', compact('barangs'));
    }


      // Fungsi untuk menampilkan form tambah barang
        public function create()
        {
            return view('barang.create');
        }

        public function edit($id)
        {
            // Mencari data barang berdasarkan ID
            $barang = Barang::findOrFail($id);

            // Mengembalikan view dengan data barang
            return view('barang.edit', compact('barang'));
        }

        public function destroy($id)
        {
            // Mencari data barang berdasarkan ID
            $barang = Barang::findOrFail($id);

            // Menghapus data barang
            $barang->delete();

            // Redirect kembali ke halaman daftar barang
            return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
        }

        public function store(Request $request)
        {
            // Validasi data
            $request->validate([
                'jenis' => 'required|string|max:30',
                'nama' => 'required|string|max:45',
                'idsatuan' => 'required|integer',
                'status' => 'required|boolean',
                'harga' => 'required|integer',
            ]);


    // Simpan data ke database
    Barang::create($request->all());

    // Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
}
    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'jenis' => 'required|string|max:30',
            'nama' => 'required|string|max:45',
            'idsatuan' => 'required|exists:satuan,idsatuan',
            'status' => 'required|boolean',
            'harga' => 'required|numeric|min:0',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Update data
        $barang->update($validatedData);

        // Redirect atau beri respon
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate.');
    }
}
