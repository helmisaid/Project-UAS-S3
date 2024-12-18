@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Margin Penjualan</h1>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xxl-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('margin_penjualan.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>

                        <div class="card-body py-4">
                            <form action="{{ route('margin_penjualan.update', $margin->idmargin_penjualan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="persen" class="form-label">Persen Margin</label>
                                    <input type="number" class="form-control" id="persen" name="persen" value="{{ $margin->persen }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1" {{ $margin->status == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $margin->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="id_karyawan" class="form-label">Karyawan</label>
                                    <select class="form-control" id="id_karyawan" name="id_karyawan" required>
                                        <option value="{{ $margin->id_karyawan }}">{{ $margin->karyawan->nama_karyawan }}</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
