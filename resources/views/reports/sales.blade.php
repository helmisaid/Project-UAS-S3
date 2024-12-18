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
                        <li class="breadcrumb-item active" aria-current="page">Laporan Penjualan</li>
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
                            <span class="text-dark fs-4 fw-bold me-2 d-block mb-2">Total Penjualan Hari Ini</span>
                            <span class="text-dark fs-2hx fw-bolder">Rp {{ number_format($todaySales, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="text-dark fs-4 fw-bold me-2 d-block mb-2">Jumlah Invoice Penjualan Hari Ini</span>
                            <span class="text-dark fs-2hx fw-bolder">{{ $todayInvoices }}</span>
                        </div>
                    </div>
                </div>
                <!-- End::Revenue Cards -->
            </div>

            <div class="row g-5 g-xl-8 mb-5">
                <div class="col-xl-6">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-primary svg-icon-3x d-block my-2">
                                <i class="fas fa-cart-plus fa-2x text-primary"></i>
                            </span>
                            <span class="text-dark fw-bolder fs-2x d-block">{{ $totalItemsSold }}</span>
                            <span class="text-gray-600 fw-bold">Total Barang Terjual</span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
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
            </div>

                <div class="col-xl-3">
                    <!-- Placeholder for future card -->
                </div>

                <div class="col-xl-3">
                    <!-- Placeholder for future card -->
                </div>


            <!-- Begin::Line Chart for Monthly Sales -->
            <div class="row g-5 g-xl-8 mb-5">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Tren Penjualan Bulanan</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <canvas id="monthlySalesChart" width="400" height="200"></canvas>
                            <button id="downloadChartBtn" class="btn btn-primary mt-3">Download Chart</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::Line Chart for Monthly Sales -->

            <!-- Begin::Profit Table -->
            <div class="row g-5 g-xl-8 mb-5">
                <div class="col-xl-12">
                    <div class="card card-xl-stretch mb-xl-8 border border-2 border-light shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Laporan Keuntungan Penjualan</span>
                            </h3>
                        </div>
                        <div class="table-responsive mt-5">
                            <table id="profitTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Total Penjualan (Rp)</th>
                                        <th>Total Biaya (Rp)</th>
                                        <th>Keuntungan (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($profitData as $data)
                                        <tr>
                                            <td>{{ $data['month_name'] }}</td>
                                            <td>{{ number_format($data['total_sales'], 0, ',', '.') }}</td>
                                            <td>{{ number_format($data['total_cost'], 0, ',', '.') }}</td>
                                            <td>{{ number_format($data['profit'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::Profit Table -->

        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
@endsection

@section('css-page')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
<!-- Custom CSS for buttons -->
<style>
    .dt-buttons {
        margin-bottom: 15px;
    }
    .dt-button {
        padding: 0.5rem 1rem;
        margin-right: 0.5rem;
        border-radius: 0.25rem;
        border: none;
    }
    .dt-button.buttons-excel {
        background-color: #198754;
        color: white;
    }
    .dt-button.buttons-pdf {
        background-color: #dc3545;
        color: white;
    }
    .dt-button.buttons-csv {
        background-color: #0d6efd;
        color: white;
    }
    .dt-button.buttons-print {
        background-color: #0dcaf0;
        color: white;
    }
</style>
@endsection

@section('scripts')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables Core -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#profitTable').DataTable({
        dom: '<"dt-buttons"B>frtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'buttons-excel',
                title: 'Laporan Keuntungan Penjualan'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'buttons-pdf',
                title: 'Laporan Keuntungan Penjualan',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                className: 'buttons-csv',
                title: 'Laporan Keuntungan Penjualan'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                className: 'buttons-print',
                title: 'Laporan Keuntungan Penjualan'
            }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        }
    });
});
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Prepare the monthly sales data for the chart
        const salesData = @json($salesData);  // Sales data passed from the controller

        // Prepare labels (months) and data (sales)
        const labels = salesData.map(item => item.month);
        const sales = salesData.map(item => item.total_sales);

        // Create the line chart
        const ctx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: sales,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Rp ' + tooltipItem.raw.toLocaleString(); // Format tooltip to show currency
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            callback: function(value) {
                                const monthNames = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ];
                                return monthNames[value - 1]; // Display full month names
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5000000, // Adjust this value to make the Y-Axis higher
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString(); // Format y-axis to show currency
                            }
                        }
                    }
                }
            }
        });

        // Download chart functionality
        document.getElementById('downloadChartBtn').addEventListener('click', function() {
            const dataUrl = monthlySalesChart.toBase64Image();
            const a = document.createElement('a');
            a.href = dataUrl;
            a.download = 'sales_report.png';  // You can change the file name and format here
            a.click();
        });
    });
</script>


@endsection

