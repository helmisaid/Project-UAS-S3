@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Jenis Karyawan</h1>
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
                            <h3 class="card-title fw-bolder text-white">Tambah Jenis Karyawan</h3>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body">
                            <form action="{{ route('jeniskaryawan.store') }}" method="POST">
                                @csrf
                                <div class="mb-10">
                                    <label for="jenis_karyawan" class="form-label">Jenis Karyawan</label>
                                    <input type="text" id="jenis_karyawan" name="jenis_karyawan" class="form-control" placeholder="Masukkan Jenis Karyawan" value="{{ old('jenis_karyawan') }}" required />
                                    @error('jenis_karyawan')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('jeniskaryawan.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
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
