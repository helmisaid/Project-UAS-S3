@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Vendor</h1>
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
                            <h3 class="card-title fw-bolder">Form Edit Vendor</h3>
                        </div>
                        <!-- End Card Header -->

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <form action="{{ route('vendor.update', $vendor->idvendor) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Nama Vendor -->
                                <div class="mb-10">
                                    <label for="nama_vendor" class="form-label">Nama Vendor</label>
                                    <input type="text" name="nama_vendor" class="form-control" id="nama_vendor" value="{{ $vendor->nama_vendor }}" required>
                                </div>

                                <!-- Badan Hukum -->
                                <div class="mb-10">
                                    <label for="badan_hukum" class="form-label">Badan Hukum</label>
                                    <select class="form-control" id="badan_hukum" name="badan_hukum" required>
                                        <option value="1" {{ $vendor->badan_hukum == '1' ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ $vendor->badan_hukum == '0' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="mb-10">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1" {{ $vendor->status == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $vendor->status == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="{{ route('vendor.index') }}" class="btn btn-secondary">Kembali</a>
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
