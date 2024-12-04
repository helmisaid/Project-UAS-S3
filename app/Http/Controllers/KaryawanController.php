<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Models\JenisKaryawan;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans', 'user'));
    }

    public function create()
    {
        $jenisKaryawans = JenisKaryawan::all();

        return view('karyawan.create', compact('jenisKaryawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'id_jenis_karyawan' => 'required|exists:jenis_karyawan,id_jenis_karyawan',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:30',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'foto_karyawan' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status' => 'required|boolean',
        ]);


        $file_name = null;
        if ($request->hasFile('foto_karyawan')) {
        $file = $request->file('foto_karyawan');
        $file_name = $file->store('uploads', 'public');
    }

    Karyawan::create([
        'nama_karyawan' => $request->nama_karyawan,
        'id_jenis_karyawan' => $request->id_jenis_karyawan,
        'email' => $request->email,
        'password' => bcrypt($request->password),  // Mengenkripsi password
        'no_telp' => $request->no_telp,
        'alamat' => $request->alamat,
        'status' => $request->status,
        'foto_karyawan' => $file_name,  // Menyimpan nama file foto
    ]);


        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $jenisKaryawans = JenisKaryawan::all();

        return view('karyawan.edit', compact('karyawan', 'jenisKaryawans'));
    }

    public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'nama_karyawan' => 'required|string|max:255',
        'id_jenis_karyawan' => 'required|exists:jenis_karyawan,id_jenis_karyawan',
        'email' => 'required|email|max:255',
        'password' => 'nullable|string|min:8|max:30', // Password boleh kosong
        'no_telp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:500',
        'foto_karyawan' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'status' => 'required|boolean',
    ]);

    // Cari karyawan berdasarkan ID
    $karyawan = Karyawan::findOrFail($id);

    // Persiapkan data yang akan diupdate
    $data = [
        'nama_karyawan' => $request->nama_karyawan,
        'id_jenis_karyawan' => $request->id_jenis_karyawan,
        'email' => $request->email,
        'no_telp' => $request->no_telp,
        'alamat' => $request->alamat,
        'status' => $request->status,
    ];

    // Cek apakah password diubah, jika ya, tambahkan ke data
    if ($request->has('password') && !empty($request->password)) {
        $data['password'] = bcrypt($request->password);
    }

    // Cek apakah ada foto yang diupload
    if ($request->hasFile('foto_karyawan')) {
        $file_name = $request->file('foto_karyawan')->store('uploads', 'public');
        $data['foto_karyawan'] = $file_name;
    }

    // Perbarui data karyawan menggunakan update()
    $karyawan->update($data);

    return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
}


    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
