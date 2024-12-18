@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Margin Penjualan</h1>
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
                            <form action="{{ route('margin_penjualan.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="persen" class="form-label">Persen Margin</label>
                                    <input type="number" class="form-control" id="persen" name="persen" required min="0">
                                    <!-- Atribut 'min="0"' memastikan input tidak bisa bernilai negatif -->
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                                <!-- Karyawan otomatis berdasarkan login -->
                                <input type="hidden" name="id_karyawan" value="{{ Auth::user()->id_karyawan }}">

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
