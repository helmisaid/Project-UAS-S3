@extends('layouts.index')

@section('content')
<div class="container">
    <h1>Daftar Vendor</h1>
    <a href="{{ route('vendor.create') }}" class="btn btn-primary">Tambah Vendor</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Vendor</th>
                <th>Badan Hukum</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendors as $vendor)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $vendor->nama_vendor }}</td>
                <td>{{ $vendor->badan_hukum == '1' ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $vendor->status == '1' ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td>
                    <a href="{{ route('vendor.edit', $vendor->idvendor) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('vendor.destroy', $vendor->idvendor) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
