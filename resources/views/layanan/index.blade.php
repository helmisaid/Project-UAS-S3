@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Daftar Layanan</h1>
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            </div>
        </div>
    </div>

    <!-- Begin Post -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <!-- Begin Row -->
            <div class="row gy-5 g-xl-8">
                <!-- Begin Col -->
                <div class="col-xxl-12">
                    <!-- Begin Card -->
                    <div class="card shadow-sm">
                        <!-- Begin Card Header -->
                        <div class="card-header bg-light py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('layanan.create') }}" class="btn btn-sm btn-primary">
                                    Tambah Layanan
                                </a>
                            </div>
                        </div>
                        <!-- End Card Header -->

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <!-- Success Message -->
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Layanan</th>

                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($layanan as $item)
                                            <tr>
                                                <td>{{ $item->nama_layanan }}</td>

                                                <td>Rp. {{ number_format($item->harga_layanan, 2, ',', '.') }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('layanan.edit', $item->id_layanan) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <form action="{{ route('layanan.destroy', $item->id_layanan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Card Body -->
                    </div>
                    <!-- End Card -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
    </div>
    <!-- End Post -->
</div>
@endsection
