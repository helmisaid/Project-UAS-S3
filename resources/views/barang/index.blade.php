@extends('layouts.index')

@section('content')
<div class="container mt-5">
    <h1>Daftar Barang</h1>

    <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Jenis</th>
                <th>Nama</th>
                <th>IDsatuan</th>
                <th>Status</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangs as $barang)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $barang->jenis }}</td>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ $barang->idsatuan }}</td>
                    <td>{{ $barang->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td>{{ $barang->harga }}</td>
                    <td>
                        <a href="{{ route('barang.edit', $barang->idbarang) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('barang.destroy', $barang->idbarang) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
