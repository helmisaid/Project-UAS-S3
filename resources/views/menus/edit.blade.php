@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Menu</h1>
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
                            <h3 class="card-title fw-bolder text-dark mb-0">Form Edit Menu</h3>
                        </div>
                        <!-- End Card Header -->

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <form action="{{ route('menus.update', $menu->menu_id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Level ID -->
                                <div class="mb-3">
                                    <label for="level_id" class="form-label">Level ID</label>
                                    <input type="number" class="form-control" id="level_id" name="level_id" value="{{ $menu->level_id }}" placeholder="Masukkan Level ID" required>
                                </div>

                                <!-- Nama Menu -->
                                <div class="mb-3">
                                    <label for="menu_name" class="form-label">Nama Menu</label>
                                    <input type="text" class="form-control" id="menu_name" name="menu_name" value="{{ $menu->menu_name }}" placeholder="Masukkan Nama Menu" required>
                                </div>

                                <!-- Link Menu -->
                                <div class="mb-3">
                                    <label for="menu_link" class="form-label">Link Menu</label>
                                    <input type="text" class="form-control" id="menu_link" name="menu_link" value="{{ $menu->menu_link }}" placeholder="Masukkan Link Menu" required>
                                </div>

                                <!-- Icon Menu -->
                                <div class="mb-3">
                                    <label for="menu_icon" class="form-label">Icon Menu</label>
                                    <input type="text" class="form-control" id="menu_icon" name="menu_icon" value="{{ $menu->menu_icon }}" placeholder="Masukkan Icon Menu" required>
                                </div>

                                <!-- Parent ID -->
                                <div class="mb-3">
                                    <label for="parent_id" class="form-label">Parent ID</label>
                                    <select class="form-select" id="parent_id" name="parent_id">
                                        <option value="" {{ is_null($menu->parent_id) ? 'selected' : '' }}>Tidak Ada</option>
                                        @foreach($datamenus as $item)
                                            <option value="{{ $item->menu_id }}" {{ $menu->parent_id == $item->menu_id ? 'selected' : '' }}>
                                                {{ $item->menu_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Dibuat Oleh -->
                                <div class="mb-3">
                                    <label for="created_by" class="form-label">Dibuat Oleh</label>
                                    <input type="text" class="form-control" id="created_by" name="created_by" value="{{ $menu->created_by }}" placeholder="Masukkan Nama Pembuat" required>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update Menu</button>
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
