@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Menu Level</h1>
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
                                <a href="{{ route('menu-levels.create') }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-lg"></i> Tambah Menu Level
                                </a>
                            </div>
                        </div>
                        <!-- End Card Header -->

                        <!-- Begin Card Body -->
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>ID Level</th>
                                            <th>Nama Level</th>
                                            <th class="text-center" style="width: 15%;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($menuLevels as $index => $menuLevel)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $menuLevel->level_id }}</td>
                                                <td>{{ $menuLevel->level }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <!-- Tombol Edit -->
                                                        <a href="{{ route('menu-levels.edit', $menuLevel->level_id) }}" class="btn btn-warning btn-sm">
                                                            Edit
                                                        </a>

                                                        <!-- Form Hapus -->
                                                        <form action="{{ route('menu-levels.destroy', $menuLevel->level_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus level ini?');" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data menu level.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
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
