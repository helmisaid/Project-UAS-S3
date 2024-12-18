@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Daftar Service Mekanik</h1>
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
                                <!-- Jika ingin menambahkan fitur lain seperti tombol tambah -->
                                <a href="#" class="btn btn-sm btn-primary">
                                    Daftar Pekerjaan
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
                                            <th>Nomor Antrian</th>
                                            <th>Jenis Kendaraan</th>
                                            <th>No. Polisi</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Status</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $service)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $service->nomor_antrian }}</td>
                                                <td>{{ $service->jenis_kendaraan }}</td>
                                                <td>{{ $service->no_pol }}</td>
                                                <td>{{ $service->nama_pelanggan }}</td>
                                                <td>
                                                    <form action="{{ route('service.updateStatus', $service->id_service) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <select name="status" class="form-control" onchange="this.form.submit()">
                                                            <option value="not started" {{ $service->status == 'not started' ? 'selected' : '' }}>Not Started</option>
                                                            <option value="pending" {{ $service->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="in-progress" {{ $service->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                                            <option value="completed" {{ $service->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="cancelled" {{ $service->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#serviceDetailModal-{{ $service->id_service }}">
                                                        Detail
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal for Service Detail -->
                                            <div class="modal fade" id="serviceDetailModal-{{ $service->id_service }}" tabindex="-1" aria-labelledby="serviceDetailModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="serviceDetailModalLabel">Detail Service #{{ $service->nomor_antrian }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5>Layanan</h5>
                                                            @if($service->detailService->isNotEmpty())
                                                                <ul>
                                                                    @foreach($service->detailService as $detail)
                                                                        @if($detail->layanan)
                                                                            <li>
                                                                                Layanan: {{ $detail->layanan->nama_layanan ?? 'N/A' }}
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p>Tidak ada layanan untuk service ini.</p>
                                                            @endif

                                                            <h5>Barang</h5>
                                                            @if($service->detailService->isNotEmpty())
                                                                <ul>
                                                                    @foreach($service->detailService as $detail)
                                                                        @if($detail->barang)
                                                                            <li>
                                                                                Barang: {{ $detail->barang->nama ?? 'N/A' }} |
                                                                                Jumlah: {{ $detail->jumlah ?? 'N/A' }} |
                                                                                Jenis Barang: {{ $detail->barang->jenis?? 'N/A' }}
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p>Tidak ada barang untuk service ini.</p>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
