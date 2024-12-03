@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Daftar Jenis Layanan</h1>
            </div>
        </div>
    </div>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card card-xxl-stretch">
                <div class="card-header border-0 bg-primary py-5">
                    <h3 class="card-title fw-bolder text-white">Jenis Layanan</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('jenis-layanan.create') }}" class="btn btn-sm btn-light">Tambah Layanan</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Layanan</th>
                                    <th>Deskripsi</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jenisLayanan as $layanan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $layanan->nama_layanan }}</td>
                                    <td>{{ $layanan->deskripsi }}</td>
                                    <td>Rp{{ number_format($layanan->harga, 2) }}</td>
                                    <td>
                                        <a href="{{ route('jenis-layanan.edit', $layanan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('jenis-layanan.destroy', $layanan->id) }}" method="POST" class="d-inline">
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
@endsection
