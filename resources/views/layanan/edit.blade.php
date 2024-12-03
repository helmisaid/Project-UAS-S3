@extends('layouts.index')

@section('content')
<div class="container">
    <h1>Edit Layanan</h1>

    <form action="{{ route('layanan.update', $layanan->id_layanan) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nama_layanan" class="form-label">Nama Layanan</label>
            <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
        </div>

        <div class="mb-3">
            <label for="id_karyawan" class="form-label">Karyawan</label>
            <select class="form-control" id="id_karyawan" name="id_karyawan" required>
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ $layanan->id_karyawan == $karyawan->id_karyawan ? 'selected' : '' }}>{{ $karyawan->nama_karyawan }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="harga_layanan" class="form-label">Harga Layanan</label>
            <input type="number" class="form-control" id="harga_layanan" name="harga_layanan" value="{{ old('harga_layanan', $layanan->harga_layanan) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
