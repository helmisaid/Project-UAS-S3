@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Menu Level</h1>
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
                            <h3 class="card-title fw-bolder text-dark">Tambah Menu Level Baru</h3>
                        </div>
                        <!-- End Card Header -->

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <!-- Error Handling -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Form -->
                            <form action="{{ route('menu-levels.store') }}" method="POST">
                                @csrf

                                <!-- Level ID -->
                                <div class="mb-3">
                                    <label for="level_id" class="form-label">ID Level</label>
                                    <input type="text" class="form-control" id="level_id" name="level_id" required>
                                </div>

                                <!-- Nama Level -->
                                <div class="mb-3">
                                    <label for="level" class="form-label">Nama Level</label>
                                    <input type="text" class="form-control" id="level" name="level" required>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('menu-levels.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                        <!-- End Card Body -->
                    </div>
                    <!-- End Card -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Post -->
</div>
@endsection
