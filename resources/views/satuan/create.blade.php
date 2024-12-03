@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl">
        <h3 class="mb-5">Tambah Satuan</h3>
        <form action="{{ route('satuan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_satuan" class="form-label">Nama Satuan</label>
                <input type="text" name="nama_satuan" id="nama_satuan" class="form-control" placeholder="Masukkan nama satuan" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('satuan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
