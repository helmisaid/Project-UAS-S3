@extends('layouts.index')

@section('content')
<div class="container">
    <h1>Edit Vendor</h1>
    <form action="{{ route('vendor.update', $vendor->idvendor) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_vendor" class="form-label">Nama Vendor</label>
            <input type="text" class="form-control" id="nama_vendor" name="nama_vendor" value="{{ $vendor->nama_vendor }}" required>
        </div>
        <div class="mb-3">
            <label for="badan_hukum" class="form-label">Badan Hukum</label>
            <select class="form-control" id="badan_hukum" name="badan_hukum" required>
                <option value="1" {{ $vendor->badan_hukum == '1' ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ $vendor->badan_hukum == '0' ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="1" {{ $vendor->status == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ $vendor->status == '0' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
