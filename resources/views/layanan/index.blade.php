@extends('layouts.index')

@section('content')
<div class="container">
    <h1>Daftar Layanan</h1>
    <a href="{{ route('layanan.create') }}" class="btn btn-primary mb-3">Tambah Layanan</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Layanan</th>
                <th>Status</th>
                <th>Karyawan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($layanan as $item)
            <tr>
                <td>{{ $item->nama_layanan }}</td>
                <td>{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td>{{ $item->karyawan->nama_karyawan }}</td>
                <td>
                    <a href="{{ route('layanan.edit', $item->id_layanan) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('layanan.destroy', $item->id_layanan) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
