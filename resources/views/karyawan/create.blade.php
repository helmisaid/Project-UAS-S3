@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Karyawan</h1>
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xxl-12">
                    <!--begin::Card-->
                    <div class="card card-xxl-stretch">
                        <!--begin::Card header-->
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title fw-bolder text-white">Form Tambah Karyawan</h3>
                        </div>
                        <!--end::Card header-->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <!--begin::Card body-->
                        <div class="card-body">

                            <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-10">
                                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                    <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control" placeholder="Masukkan nama karyawan" required />
                                </div>

                                <div class="mb-3">
                                    <label for="id_jenis_karyawan" class="form-label">Jenis Karyawan</label>
                                    <select class="form-control" id="id_jenis_karyawan" name="id_jenis_karyawan" required>
                                        <option value="">Pilih Jenis Karyawan</option>
                                        @foreach($jenisKaryawans as $jenisKaryawan)
                                            <option value="{{ $jenisKaryawan->id_jenis_karyawan }}">
                                                {{ $jenisKaryawan->jenis_karyawan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-10">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email Karyawan" required />
                                </div>

                                <div class="mb-10">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password Karyawan" required />
                                </div>

                                <div class="mb-10">
                                    <label for="not_telp" class="form-label">No Telepon</label>
                                    <input type="text" id="not_telp" name="no_telp" class="form-control" placeholder="Masukkan No Telepon/Whatsapp Karyawan"/>
                                </div>

                                <div class="mb-10">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Alamat Karyawan" required></textarea>
                                </div>

                                <!-- Foto Karyawan -->
                                <div class="mb-10">
                                    <label for="foto_karyawan" class="form-label">Foto Karyawan</label>
                                    <input type="file" id="foto_karyawan" name="foto_karyawan" class="form-control" accept="image/*" />
                                    <div class="form-text text-muted">Pilih foto karyawan (optional).</div>
                                </div>

                                <!-- Status Karyawan -->
                                <div class="mb-10">
                                    <label class="form-label">Status Karyawan</label><br>
                                    <label class="form-check-label" for="status_aktif">
                                        <input type="radio" id="status_aktif" name="status" value="1" checked> Aktif
                                    </label><br>
                                    <label class="form-check-label" for="status_nonaktif">
                                        <input type="radio" id="status_nonaktif" name="status" value="0"> Tidak Aktif
                                    </label>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
            </div>
        </div>
    </div>
    <!--end::Post-->
</div>
@endsection
