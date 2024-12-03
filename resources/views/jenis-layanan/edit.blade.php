@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl">
        <h3 class="mb-5">Edit Jenis Layanan</h3>
        <form action="{{ route('jenis-layanan.update', $jenisLayanan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama_layanan" class="form-label">Nama Layanan</label>
                <input type="text" name="nama_layanan" id="nama_layanan" class="form-control" value="{{ $jenisLayanan->nama_layanan }}" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ $jenisLayanan->deskripsi }}</textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control" value="{{ $jenisLayanan->harga }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('jenis-layanan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
