@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Karyawan</h1>
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            </div>
        </div>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xxl-12">
                    <!--begin::Card-->
                    <div class="card card-xxl-stretch">
                        <!--begin::Card header-->
                        <div class="card-header border-0 bg-primary py-5">
                            <h3 class="card-title fw-bolder text-white">Form Edit Karyawan</h3>
                        </div>
                        <!--end::Card header-->

                        <!--begin::Card body-->
                        <div class="card-body">
                            <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-10">
                                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                    <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control" value="{{ old('nama_karyawan', $karyawan->nama_karyawan) }}" placeholder="Masukkan nama karyawan" required />
                                </div>

                                <div class="mb-3">
                                    <label for="id_jenis_karyawan" class="form-label">Jenis Karyawan</label>
                                    <select class="form-control" id="id_jenis_karyawan" name="id_jenis_karyawan" required>
                                        <option value="">Pilih Jenis Karyawan</option>
                                        @foreach($jenisKaryawans as $jenisKaryawan)
                                            <option value="{{ $jenisKaryawan->id_jenis_karyawan }}"
                                                {{ $jenisKaryawan->id_jenis_karyawan == $karyawan->id_jenis_karyawan ? 'selected' : '' }}>
                                                {{ $jenisKaryawan->jenis_karyawan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-10">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $karyawan->email) }}" placeholder="Masukkan Email Karyawan" required />
                                </div>

                                <div class="mb-10">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password Karyawan" />
                                    <div class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</div>
                                </div>


                                <div class="mb-10">
                                    <label for="no_telp" class="form-label">No Telepon</label>
                                    <input type="text" id="no_telp" name="no_telp" class="form-control" value="{{ old('no_telp', $karyawan->no_telp) }}" placeholder="Masukkan No Telepon Karyawan" />
                                </div>

                                <div class="mb-10">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Alamat Karyawan">{{ old('alamat', $karyawan->alamat) }}</textarea>
                                </div>

                                <div class="mb-10">
                                    <label for="foto_karyawan" class="form-label">Foto Karyawan</label>
                                    <input type="file" id="foto_karyawan" name="foto_karyawan" class="form-control" accept="image/*" />
                                    @if($karyawan->foto_karyawan)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $karyawan->foto_karyawan) }}" alt="Foto Karyawan" class="img-thumbnail" width="150">
                                        </div>
                                    @endif
                                    <div class="form-text text-muted">Pilih foto karyawan jika ingin mengubahnya.</div>
                                </div>

                                <div class="mb-10">
                                    <label class="form-label">Status Karyawan</label><br>
                                    <label class="form-check-label" for="status_aktif">
                                        <input type="radio" id="status_aktif" name="status" value="1" {{ $karyawan->status ? 'checked' : '' }}> Aktif
                                    </label><br>
                                    <label class="form-check-label" for="status_nonaktif">
                                        <input type="radio" id="status_nonaktif" name="status" value="0" {{ !$karyawan->status ? 'checked' : '' }}> Tidak Aktif
                                    </label>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
