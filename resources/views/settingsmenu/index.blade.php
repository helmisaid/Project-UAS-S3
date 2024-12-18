@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Setting Menu User</h1>
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
                                <h3 class="card-title fw-bold mb-0">Daftar Setting Menu User</h3>
                                <a href="{{ route('settingmenuuser.create') }}" class="btn btn-sm btn-primary">
                                    Tambah Setting
                                </a>
                            </div>
                        </div>
                        <!-- End Card Header -->

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <!-- Table Responsive -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>No Setting</th>
                                            <th>Jenis User</th>
                                            <th>Menu</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Dibuat Pada</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($settings as $index => $settingMenuUser)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $settingMenuUser->no_setting }}</td>
                                            <td>{{ $settingMenuUser->jenisKaryawan->jenis_karyawan }}</td>
                                            <td>{{ $settingMenuUser->menu->menu_name }}</td>
                                            <td>{{ $settingMenuUser->created_by }}</td>
                                            <td>{{ $settingMenuUser->created_at ? $settingMenuUser->created_at->format('d M, Y') : 'Tidak Tersedia' }}</td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center">
                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('settingmenuuser.edit', $settingMenuUser->no_setting) }}" class="btn btn-warning btn-sm">
                                                        Edit
                                                    </a>
                                                    <!-- Form Hapus -->
                                                    <form action="{{ route('settingmenuuser.destroy', $settingMenuUser->no_setting) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            Hapus
                                                        </button>
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
