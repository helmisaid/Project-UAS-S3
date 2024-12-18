@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Kartu Stok</h1>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                </svg>
                            </span>
                            <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-15" placeholder="Cari Barang..." />
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="stockTable">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Stok Terakhir</th>
                                <th>Terakhir Diupdate</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-bold">
                            @foreach ($currentStocks as $stock)
                            <tr>
                                <td>{{ $stock->idbarang }}</td>
                                <td>{{ $stock->nama_barang }}</td>
                                <td>{{ $stock->stock }}</td>
                                <td>{{ $stock->created_at }}</td>
                                <td>
                                    <a href="{{ route('kartustok.detail', $stock->idbarang) }}" class="btn btn-sm btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    table = document.getElementById('stockTable');
    tr = table.getElementsByTagName('tr');

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td')[1]; // Index 1 is the Nama Barang column
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
});
</script>
@endsection
