@extends('layouts.index')

@section('content')
<div class="container">
    <h1>Edit Layanan</h1>
    <form action="{{ route('layanan.update', $layanan->id_layanan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_layanan">Nama Layanan</label>
            <input type="text" name="nama_layanan" id="nama_layanan" class="form-control" value="{{ $layanan->nama_layanan }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ $layanan->status == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $layanan->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <div class="form-group">
            <label for="id_karyawan">Karyawan</label>
            <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ $layanan->id_karyawan == $karyawan->id_karyawan ? 'selected' : '' }}>
                        {{ $karyawan->nama_karyawan }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
