@extends('layouts.index')

@section('content')
<div class="container card my-4 p-4 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Retur Barang</h1>
        <span class="badge bg-primary fs-5">ID Pengadaan: <span id="idPengadaanLabel">-</span></span>
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
    <div class="mb-3">
        <label for="idpengadaan" class="form-label">Masukkan ID Pengadaan</label>
        <input type="text" class="form-control" id="idpengadaan" placeholder="Masukkan ID Pengadaan">
    </div>

    <button class="btn btn-primary" id="loadDetailBtn">Load Detail Penerimaan</button>

    <div id="detailPenerimaanTable" class="mt-4" style="display:none;">
        <h3>Detail Penerimaan</h3>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Penerimaan ID</th>
                        <th>Tanggal Penerimaan</th>
                        <th>Status</th>
                        <th>Nama User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="detailPenerimaanBody">
                    <!-- Data penerimaan akan dimuat di sini -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Penerimaan -->
<div class="modal fade" id="modalDetailPenerimaan" tabindex="-1" aria-labelledby="modalDetailPenerimaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailPenerimaanLabel">Penerimaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Jumlah Terima</th>
                            <th>Harga Satuan</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody id="modalDetailBody">
                        <!-- Detail penerimaan akan dimuat di sini -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Retur -->
<div class="modal fade" id="modalRetur" tabindex="-1" aria-labelledby="modalReturLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReturLabel">Form Retur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRetur" method="POST" action="{{ route('retur.store') }}">
                    @csrf
                    <input type="hidden" id="returIdPenerimaan" name="idpenerimaan">

                    <div class="table-responsive mb-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Terima</th>
                                    <th>Harga Satuan</th>
                                    <th>Sub Total</th>
                                    <th>Jumlah Retur</th>
                                </tr>
                            </thead>
                            <tbody id="returDetailPenerimaanBody">
                                <!-- Data detail penerimaan akan dimuat di sini -->
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <label for="alasanRetur" class="form-label">Alasan Retur</label>
                        <textarea class="form-control" id="alasanRetur" name="alasan" rows="3" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Retur</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let penerimaanData = []; // Variabel global untuk menyimpan data penerimaan

    document.getElementById('loadDetailBtn').addEventListener('click', function() {
        var idPengadaan = document.getElementById('idpengadaan').value;

        if (!idPengadaan) {
            alert("ID Pengadaan harus diisi!");
            return;
        }

        fetch('{{ route('retur.loadDetail') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ idpengadaan: idPengadaan })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
            } else {
                // Simpan data penerimaan ke variabel global
                penerimaanData = data.penerimaan;

                document.getElementById('idPengadaanLabel').textContent = idPengadaan;
                var tableBody = document.getElementById('detailPenerimaanBody');
                tableBody.innerHTML = '';

                data.penerimaan.forEach(function(penerimaan) {
                    var status = penerimaan.status === '1' ? 'Selesai' : 'Proses Retur';
                    var penerimaanRow = document.createElement('tr');
                    penerimaanRow.innerHTML = `
                        <td>${penerimaan.idpenerimaan}</td>
                        <td>${penerimaan.tanggal_penerimaan || 'Tanggal tidak tersedia'}</td>
                        <td>${status}</td>
                        <td>${penerimaan.nama_user || 'Nama user tidak tersedia'}</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="showDetailModal(${penerimaan.idpenerimaan})">Detail</button>
                            <button class="btn btn-danger btn-sm" onclick="openReturForm(${penerimaan.idpenerimaan})">Retur</button>
                        </td>
                    `;
                    tableBody.appendChild(penerimaanRow);
                });

                document.getElementById('detailPenerimaanTable').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data.');
        });
    });

    function showDetailModal(idPenerimaan) {
        var penerimaan = penerimaanData.find(penerimaan => penerimaan.idpenerimaan === idPenerimaan);
        var modalBody = document.getElementById('modalDetailBody');
        modalBody.innerHTML = '';

        penerimaan.details.forEach(function(item) {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.nama_barang}</td>
                <td>${item.jumlah_terima}</td>
                <td>${item.harga_satuan}</td>
                <td>${item.sub_total}</td>
            `;
            modalBody.appendChild(row);
        });

        var myModal = new bootstrap.Modal(document.getElementById('modalDetailPenerimaan'));
        myModal.show();
    }

    function openReturForm(idPenerimaan) {
        document.getElementById('returIdPenerimaan').value = idPenerimaan;
        var penerimaan = penerimaanData.find(item => item.idpenerimaan === idPenerimaan);

        if (!penerimaan) {
            alert('Data penerimaan tidak ditemukan.');
            return;
        }

        var returDetailBody = document.getElementById('returDetailPenerimaanBody');
        returDetailBody.innerHTML = '';

        penerimaan.details.forEach(function(item) {
            var row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <input type="checkbox" class="form-check-input pilih-barang" name="barang[${item.iddetail_penerimaan}][iddetail_penerimaan]" value="${item.iddetail_penerimaan}">
                </td>
                <td>${item.nama_barang}</td>
                <td>${item.jumlah_terima}</td>
                <td>${item.harga_satuan}</td>
                <td>${item.sub_total}</td>
                <td>
                    <input type="number" class="form-control jumlah-retur" name="barang[${item.iddetail_penerimaan}][jumlah_retur]" min="1" max="${item.jumlah_terima}" disabled>
                </td>
            `;
            returDetailBody.appendChild(row);
        });

        var modalRetur = new bootstrap.Modal(document.getElementById('modalRetur'));
        modalRetur.show();

        document.querySelectorAll('.pilih-barang').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                const jumlahReturInput = row.querySelector('.jumlah-retur');
                jumlahReturInput.disabled = !this.checked;
                if (!this.checked) {
                    jumlahReturInput.value = '';
                }
            });
        });
    }

    document.getElementById('formRetur').addEventListener('submit', function(event) {
        event.preventDefault();

        let returData = {
            idpenerimaan: document.getElementById('returIdPenerimaan').value,
            barang: [],
            alasan: document.getElementById('alasanRetur').value
        };

        document.querySelectorAll('.pilih-barang:checked').forEach(function(checkbox) {
            const iddetail_penerimaan = checkbox.value;
            const jumlahReturInput = checkbox.closest('tr').querySelector('.jumlah-retur');
            const jumlahRetur = parseInt(jumlahReturInput.value);

            if (jumlahRetur && jumlahRetur > 0) {
                returData.barang.push({
                    iddetail_penerimaan: iddetail_penerimaan,
                    jumlah_retur: jumlahRetur
                });
            }
        });

        if (returData.barang.length === 0) {
            alert('Silakan pilih barang yang ingin diretur dengan jumlah yang valid.');
            return;
        }

        // Send the data using fetch API
        fetch('{{ route('retur.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(returData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Retur berhasil disimpan');
                location.reload(); // Reload the page or update the UI as needed
            } else {
                alert('Gagal menyimpan retur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan retur.');
        });
    });
</script>

@endsection

