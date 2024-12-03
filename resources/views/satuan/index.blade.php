@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl">
        <h3 class="mb-5">Daftar Satuan</h3>
        <a href="{{ route('satuan.create') }}" class="btn btn-primary mb-3">Tambah Satuan</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Satuan</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($satuan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_satuan }}</td>
                        <td>
                            @if($item->status == 1)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('satuan.edit', $item->idsatuan) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('satuan.destroy', $item->idsatuan) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
