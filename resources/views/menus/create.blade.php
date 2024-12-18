@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Menu</h1>
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            </div>
        </div>
    </div>

    <!-- Begin Post -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xxl-12">
                    <!-- Begin Card -->
                    <div class="card shadow-sm">
                        <!-- Begin Card Header -->
                        <div class="card-header bg-light py-4">
                            <h3 class="card-title fw-bolder text-dark mb-0">Form Tambah Menu</h3>
                        </div>
                        <!-- End Card Header -->

                        <!-- Display Errors -->
                        @if ($errors->any())
                        <div class="alert alert-danger mt-3 mx-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <form action="{{ route('menus.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="menu_name" class="form-label">Nama Menu</label>
                                    <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="Masukkan nama menu" required>
                                </div>

                                <div class="mb-3">
                                    <label for="menu_link" class="form-label">Link Menu</label>
                                    <input type="text" class="form-control" id="menu_link" name="menu_link" placeholder="Masukkan link menu" required>
                                </div>

                                <div class="mb-3">
                                    <label for="menu_icon" class="form-label">Icon Menu</label>
                                    <input type="text" class="form-control" id="menu_icon" name="menu_icon" placeholder="Masukkan icon menu" required>
                                </div>

                                <div class="mb-3">
                                    <label for="level_id" class="form-label">Level ID</label>
                                    <select class="form-select" id="level_id" name="level_id" required>
                                        <option value="" disabled selected>Pilih Level ID</option>
                                        @foreach($menuLevels as $level)
                                            <option value="{{ $level->level_id }}">{{ $level->level }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Parent ID</label>
                                    <select class="form-select" id="parent_id" name="parent_id">
                                        <option value="">Tidak Ada</option>
                                        @foreach($datamenus as $menu)
                                            <option value="{{ $menu->menu_id }}">{{ $menu->menu_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="created_by" class="form-label">Dibuat Oleh</label>
                                    <input type="text" class="form-control" id="created_by" name="created_by" placeholder="Masukkan nama pembuat" required>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Menu</button>
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
