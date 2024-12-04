@extends('layouts.index')

@section('content')
<div class="container">
    <h1>Tambah Vendor</h1>
    <form action="{{ route('vendor.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_vendor" class="form-label">Nama Vendor</label>
            <input type="text" class="form-control" id="nama_vendor" name="nama_vendor" required>
        </div>
        <div class="mb-3">
            <label for="badan_hukum" class="form-label">Badan Hukum</label>
            <select class="form-control" id="badan_hukum" name="badan_hukum" required>
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
