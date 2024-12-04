@extends('layouts.index')

@section('content')
<div class="container mt-5">
    <h1>Edit Barang</h1>
    <form action="{{ route('barang.update', $barang->idbarang) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="jenis" class="form-label">Jenis</label>
            <input type="text" name="jenis" class="form-control" id="jenis" value="{{ $barang->jenis }}" required>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" id="nama" value="{{ $barang->nama }}" required>
        </div>
        <div class="mb-3">
            <label for="idsatuan" class="form-label">Idsatuan</label>
            <input type="number" name="idsatuan" class="form-control" id="idsatuan" value="{{ $barang->idsatuan }}" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1" {{ $barang->status ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !$barang->status ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" id="harga" value="{{ $barang->harga }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
