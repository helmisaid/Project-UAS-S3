@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Daftar Margin Penjualan</h1>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xxl-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('margin_penjualan.create') }}" class="btn btn-sm btn-primary">Tambah Margin Penjualan</a>
                            </div>
                        </div>

                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Persen</th>
                                            <th>Status</th>
                                            <th>Karyawan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($margins as $margin)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $margin->persen }}%</td>
                                                <td>{{ $margin->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                                                <td>{{ $margin->karyawan->nama_karyawan }}</td>
                                                <td>
                                                    <a href="{{ route('margin_penjualan.edit', $margin->idmargin_penjualan) }}" class="btn btn-warning btn-sm">Edit</a>
                                                    <form action="{{ route('margin_penjualan.destroy', $margin->idmargin_penjualan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
