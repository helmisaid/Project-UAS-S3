@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Setting Menu User</h1>
            </div>
        </div>
    </div>

    <!-- Begin Post -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xxl-12">
                    <div class="card shadow-sm">
                        <!-- Begin Card Header -->
                        <div class="card-header bg-light py-4">
                            <h3 class="card-title fw-bold mb-0">Edit Setting Menu User</h3>
                        </div>
                        <!-- End Card Header -->

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <form action="{{ route('settingmenuuser.update', $settingMenuUser->no_setting) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Jenis User -->
                                <div class="form-group mb-3">
                                    <label for="id_jenis_karyawan" class="form-label">Jenis User</label>
                                    <select name="id_jenis_karyawan" class="form-control" required>
                                        <option value="">Pilih Jenis User</option>
                                        @foreach($jenisKaryawan as $jenisUser)
                                            <option value="{{ $jenisUser->id_jenis_karyawan }}"
                                                {{ $settingMenuUser->id_jenis_karyawan == $jenisUser->id_jenis_karyawan ? 'selected' : '' }}>
                                                {{ $jenisUser->jenis_karyawan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Menu -->
                                <div class="form-group mb-3">
                                    <label for="menu_id" class="form-label">Menu</label>
                                    <select name="menu_id" class="form-control" required>
                                        <option value="">Pilih Menu</option>
                                        @foreach($datamenus as $menu)
                                            <option value="{{ $menu->menu_id }}"
                                                {{ $settingMenuUser->menu_id == $menu->menu_id ? 'selected' : '' }}>
                                                {{ $menu->menu_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Dibuat Oleh -->
                                <div class="form-group mb-3">
                                    <label for="created_by" class="form-label">Dibuat Oleh</label>
                                    <input type="text" name="created_by" class="form-control" value="{{ $settingMenuUser->created_by }}" >
                                </div>

                                <!-- Button Submit -->
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('settingmenuuser.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                        <!-- End Card Body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Post -->
</div>
@endsection
