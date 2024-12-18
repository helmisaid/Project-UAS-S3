@extends('layouts.index')

@section('content')

<!-- Modal Detail Penerimaan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Penerimaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <!-- Data detail penerimaan akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!-- Toolbar -->
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex justify-content-between align-items-center flex-wrap me-3 mb-5 mb-lg-0 w-100">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Penerimaan Barang</h1>
                <span class="badge bg-primary fs-5 ms-auto">ID Pengadaan: {{ $idPengadaan }}</span>
            </div>
        </div>
    </div>


    <!-- Main Content -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xxl-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form id="penerimaanForm" action="{{ route('penerimaan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_pengadaan" value="{{ $idPengadaan }}">

                                <!-- Table for Receiving Goods -->
                                <h2 class="mt-2 mb-3">Tambah Penerimaan</h2>
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Pesan</th>
                                            <th>Total Diterima</th>
                                            <th>Sisa</th>
                                            <th>Jumlah Terima</th>
                                            <th>Harga Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($barangPengadaan && count($barangPengadaan) > 0)
                                            @foreach ($barangPengadaan as $barang)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="barang[{{ $barang->idbarang }}][terima]" value="1">
                                                </td>
                                                <td>{{ $barang->nama_barang }}</td>
                                                <td>{{ $barang->jumlah_pesan }}</td>
                                                <td>{{ $barang->total_terima ?? 0 }}</td>
                                                <td>{{ $barang->sisa }}</td>
                                                <td>
                                                    <input type="number" name="barang[{{ $barang->idbarang }}][jumlah_terima]"
                                                           class="form-control"
                                                           min="1"
                                                           max="{{ $barang->sisa }}"
                                                           placeholder="Jumlah Terima">
                                                </td>
                                                <td>
                                                    <input type="number" name="barang[{{ $barang->idbarang }}][harga_satuan]"
                                                           class="form-control"
                                                           value="{{ $barang->harga }}" readonly>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada barang untuk pengadaan ini.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-primary">Simpan Penerimaan</button>
                            </form>
                        </div>
                    </div>

                    <!-- History of Receipts -->

                    <div class="card shadow-sm mt-5">
                        <div class="card-body">
                            <h2 class="mt-5 mb-3">History Penerimaan</h2>
                            <table class="table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID Penerimaan</th>
                                        <th>Tanggal Penerimaan</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Terima</th>
                                        <th>Harga Satuan</th>
                                        <th>Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($historyPenerimaan as $history)
                                    <tr>
                                        <td>{{ $history->idpenerimaan }}</td>
                                        <td>{{ $history->created_at }}</td>
                                        <td>{{ $history->nama_barang }}</td>
                                        <td>{{ $history->jumlah_terima }}</td>
                                        <td>{{ number_format($history->harga_satuan_terima, 0, ',', '.') }}</td>
                                        <td>{{ number_format($history->sub_total_terima, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada penerimaan untuk pengadaan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
