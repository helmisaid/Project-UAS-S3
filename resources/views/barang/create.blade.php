@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Barang</h1>
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            </div>
        </div>
    </div>

    <!-- Begin Post -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <!-- Begin Column -->
                <div class="col-xxl-12">
                    <!-- Begin Card -->
                    <div class="card shadow-sm">
                        <!-- Begin Card Header -->
                        <div class="card-header bg-light py-4">
                            <h3 class="card-title fw-bolder">Form Tambah Barang</h3>
                        </div>
                        <!-- End Card Header -->

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <form action="{{ route('barang.store') }}" method="POST">
                                @csrf

                                <!-- Jenis Barang -->
                                <div class="mb-10">
                                    <label for="jenis" class="form-label">Jenis Barang</label>
                                    <input type="text" name="jenis" class="form-control" id="jenis" required>
                                </div>

                                <!-- Nama Barang -->
                                <div class="mb-10">
                                    <label for="nama" class="form-label">Nama Barang</label>
                                    <input type="text" name="nama" class="form-control" id="nama" required>
                                </div>

                                <!-- IDsatuan -->
                                <div class="mb-10">
                                    <label for="idsatuan" class="form-label">IDsatuan</label>
                                    <select name="idsatuan" id="idsatuan" class="form-control" required>
                                        <option value="" disabled selected>Pilih Satuan</option>
                                        @foreach($satuans as $satuan)
                                            <option value="{{ $satuan->idsatuan }}">{{ $satuan->nama_satuan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="mb-10">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>

                                <!-- Harga -->
                                <div class="mb-10">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" class="form-control" id="harga" required>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                        <!-- End Card Body -->
                    </div>
                    <!-- End Card -->
                </div>
                <!-- End Column -->
            </div>
        </div>
    </div>
    <!-- End Post -->
</div>
@endsection
