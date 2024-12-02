@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Daftar Karyawan</h1>
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            </div>
        </div>
    </div>
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xxl-12">
                    <!--begin::Card-->
                    <div class="card card-xxl-stretch">
                        <!--begin::Card header-->
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title fw-bolder text-white">Daftar Karyawan</h3>
                            <div class="card-toolbar">
                                <a href="{{ route('karyawan.create') }}" class="btn btn-sm btn-color-white btn-active-white btn-active-color- border-0 me-n3">

                                    Tambah Karyawan
                                </a>
                            </div>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="fw-bold fs-6 text-gray-800">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Email</th>
                                            <th>Telepon</th>
                                            <th>Alamat</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawans as $karyawan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $karyawan->nama_karyawan }}</td>
                                            <td>{{ $karyawan->id_jenis_karyawan }}</td>
                                            <td>{{ $karyawan->email }}</td>
                                            <td>{{ $karyawan->no_telp }}</td>
                                            <td>{{ $karyawan->alamat }}</td>
                                            <td>
                                                <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('karyawan.destroy', $karyawan->id_karyawan) }}" method="POST" class="d-inline">
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
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->
</div>
@endsection