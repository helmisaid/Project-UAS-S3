@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div class="container-xxl d-flex flex-stack">
            <!-- Breadcrumb -->
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a></li>

                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-8 mb-5">
                <!-- Begin::Revenue Cards -->
                <div class="col-xl-6">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="text-dark fs-4 fw-bold me-2 d-block mb-2">Penjualan Hari Ini</span>
                            <span class="text-dark fs-2hx fw-bolder">Rp {{ number_format($todaySales, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="text-dark fs-4 fw-bold me-2 d-block mb-2">Invoice Penjualan Cash Hari Ini</span>
                            <span class="text-dark fs-2hx fw-bolder">{{ $todayInvoices }}</span>
                        </div>
                    </div>
                </div>
                <!-- End::Revenue Cards -->
            </div>

            <!-- Begin::Statistics Cards -->
            <div class="row g-5 g-xl-8 mb-5">
                <div class="col-xl-3">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-primary svg-icon-3x d-block my-2">
                                <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                            </span>
                            <span class="text-dark fw-bolder fs-2x d-block">{{ $totalItemsSold }}</span>
                            <span class="text-gray-600 fw-bold">Total Barang Terjual</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-success svg-icon-3x d-block my-2">
                                <i class="fas fa-box fa-2x text-success"></i>
                            </span>
                            <span class="text-dark fw-bolder fs-2x d-block">{{ $totalItems }}</span>
                            <span class="text-gray-600 fw-bold">Jumlah Barang</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-info svg-icon-3x d-block my-2">
                                <i class="fas fa-file-invoice fa-2x text-info"></i>
                            </span>
                            <span class="text-dark fw-bolder fs-2x d-block">{{ $totalInvoices }}</span>
                            <span class="text-gray-600 fw-bold">Total Invoice Penjualan</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-warning svg-icon-3x d-block my-2">
                                <i class="fas fa-tools fa-2x text-warning"></i>
                            </span>
                            <span class="text-dark fw-bolder fs-2x d-block">{{ $newServices }}</span>
                            <span class="text-gray-600 fw-bold">Servis Masuk Hari Ini</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::Statistics Cards -->

            <!-- Begin::Service Status Cards -->
            <div class="row g-5 g-xl-8 mb-5">
                <div class="col-xl-4">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-primary svg-icon-3x d-block my-2">
                                <i class="fas fa-cog fa-2x text-primary"></i>
                            </span>
                            <span class="text-dark fw-bolder fs-2x d-block">{{ $inProcessServices }}</span>
                            <span class="text-gray-600 fw-bold">Proses Pengerjaan</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-success svg-icon-3x d-block my-2">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </span>
                            <span class="text-dark fw-bolder fs-2x d-block">{{ $readyServices }}</span>
                            <span class="text-gray-600 fw-bold">Servis Bisa Diambil</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-info svg-icon-3x d-block my-2">
                                <i class="fas fa-flag-checkered fa-2x text-info"></i>
                            </span>
                            <span class="text-dark fw-bolder fs-2x d-block">{{ $completedServices }}</span>
                            <span class="text-gray-600 fw-bold">Servis Selesai Hari Ini</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::Service Status Cards -->

            <!-- Begin::Data Tables -->
            <div class="row g-5 g-xl-8">
                <!-- Begin::Popular Items -->
                <div class="col-xl-6">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Data Barang Terlaris</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="min-w-150px">Nama Barang</th>
                                            <th class="min-w-140px">Total Terjual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($popularItems as $item)
                                        <tr>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->total_sold }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End::Popular Items -->

                <!-- Begin::Low Stock Items -->
                <div class="col-xl-6">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Data Stok Terkecil</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="min-w-150px">Nama Barang</th>
                                            <th class="min-w-140px">Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lowStockItems as $item)
                                        <tr>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->stock }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End::Low Stock Items -->
            </div>
            <!-- End::Data Tables -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
@endsection

@push('scripts')
<script>
    // Add any additional JavaScript here if needed
</script>
@endpush
