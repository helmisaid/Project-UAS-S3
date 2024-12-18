@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">
                    Detail Kartu Stok - {{ $barang->nama }}
                </h1>
            </div>
            <div class="d-flex align-items-center py-1">
                <a href="{{ route('kartustok.index') }}" class="btn btn-sm btn-light btn-active-light-primary me-2">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th>Tanggal</th>
                                <th>Jenis Transaksi</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Stok</th>
                                <th>ID Transaksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($stockHistory as $history)
                            <tr>
                                <td>{{ $history->created_at }}</td>
                                <td>{{ $history->jenis_transaksi }}</td>
                                <td>{{ $history->masuk }}</td>
                                <td>{{ $history->keluar }}</td>
                                <td>{{ $history->stock }}</td>
                                <td>{{ $history->idtransaksi }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
