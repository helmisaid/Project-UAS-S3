@extends('layouts.index')

@section('content')
<div class="container">
    <h1>Tambah Layanan</h1>
    <form action="{{ route('layanan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_layanan">Nama Layanan</label>
            <input type="text" name="nama_layanan" id="nama_layanan" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>
        </div>
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
</div>
@endsection
