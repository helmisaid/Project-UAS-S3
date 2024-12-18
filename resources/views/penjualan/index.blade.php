@extends('layouts.index')


@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Tambah Penjualan</h1>
            </div>
        </div>
    </div>

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row gy-5 g-xl-8">
                <div class="col-xxl-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

                    <form id="addPenjualanForm" action="{{ route('penjualan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <h5 class="card-title">Detail Barang</h5>
                            <div id="barang-container">
                                <div class="form-group row barang-row">
                                    <div class="col-md-4">
                                        <label>Barang</label>
                                        <select class="form-control barang-select select2" name="items[0][idbarang]" data-index="0" required>
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach ($barangs as $barang)
                                                <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Harga Satuan</label>
                                        <input type="number" class="form-control harga-satuan" name="items[0][harga]" placeholder="Harga Satuan" readonly required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Jumlah</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-danger btn-sm minus-qty" data-index="0">-</button>
                                            <input type="number" class="form-control jumlah-barang" name="items[0][jumlah]" placeholder="Jumlah" value="1" data-index="0" min="0" required>
                                            <button type="button" class="btn btn-success btn-sm plus-qty" data-index="0">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button type="button" class="btn btn-danger remove-item">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success mt-3" id="add-new-barang">Tambah Barang Lain</button>
                        </div>

                        <!-- Input PPN -->
                        <div class="form-group mt-4">
                            <label for="ppnInput">PPN (%)</label>
                            <input type="number" class="form-control" id="ppnInput" name="ppn" value="0" min="0" max="100" required>
                        </div>

                        <!-- Input Diskon -->
                        <div class="form-group mt-4">
                            <label for="discountInput">Diskon (%)</label>
                            <input type="number" class="form-control" id="discountInput" name="discount" value="0" min="0" max="100" required>
                        </div>

                        <!-- Input Pembayaran -->
                        <div class="form-group mt-4">
                            <label for="paymentInput">Jumlah Bayar (Rp)</label>
                            <input type="number" class="form-control" id="paymentInput" name="payment" value="0" min="0" required>
                        </div>


                        <!-- Ringkasan -->
                        <div class="mt-4">
                            <h5>Ringkasan</h5>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span id="subtotal" class="fw-bold">Rp 0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>PPN:</span>
                                    <span id="ppn" class="fw-bold">Rp 0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Diskon:</span>
                                    <span id="discount" class="fw-bold">Rp 0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total:</span>
                                    <span id="total" class="fw-bold">Rp 0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Jumlah Bayar:</span>
                                    <span id="payment" class="fw-bold">Rp 0</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Kembalian:</span>
                                    <span id="change" class="fw-bold">Rp 0</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    let itemIndex = 1;

    // Tambah barang baru
    document.getElementById('add-new-barang').addEventListener('click', function () {
        const container = document.getElementById('barang-container');
        const newBarangRow = document.createElement('div');
        newBarangRow.classList.add('form-group', 'row', 'barang-row');
        newBarangRow.innerHTML = `
            <div class="col-md-4">
                <label>Barang</label>
                <select class="form-control barang-select" name="items[${itemIndex}][idbarang]" data-index="${itemIndex}" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Harga Satuan</label>
                <input type="number" class="form-control harga-satuan" name="items[${itemIndex}][harga]" placeholder="Harga Satuan" readonly required>
            </div>
            <div class="col-md-3">
                <label>Jumlah</label>
                <div class="input-group">
                    <button type="button" class="btn btn-danger btn-sm minus-qty" data-index="${itemIndex}">-</button>
                    <input type="number" class="form-control jumlah-barang" name="items[${itemIndex}][jumlah]" placeholder="Jumlah" value="1" min="1" data-index="${itemIndex}" required>
                    <button type="button" class="btn btn-success btn-sm plus-qty" data-index="${itemIndex}">+</button>
                </div>
            </div>
            <div class="col-md-2 mt-4">
                <button type="button" class="btn btn-danger remove-item">Hapus</button>
            </div>
        `;

        container.appendChild(newBarangRow);

        // Tambah event listener
        newBarangRow.querySelector('.barang-select').addEventListener('change', updateRingkasan);
        newBarangRow.querySelector('.jumlah-barang').addEventListener('input', updateRingkasan);
        newBarangRow.querySelector('.plus-qty').addEventListener('click', incrementQty);
        newBarangRow.querySelector('.minus-qty').addEventListener('click', decrementQty);
        newBarangRow.querySelector('.remove-item').addEventListener('click', function () {
            newBarangRow.remove();
            updateRingkasan();
        });

        itemIndex++;
    });

    function incrementQty(event) {
        const input = event.target.parentElement.querySelector('.jumlah-barang');
        input.value = parseInt(input.value) + 1; // Tambah 1 ke jumlah
        updateRingkasan();
    }

    function decrementQty(event) {
        const input = event.target.parentElement.querySelector('.jumlah-barang');
        if (parseInt(input.value) > 1) { // Cegah jumlah menjadi kurang dari 1
            input.value = parseInt(input.value) - 1;
            updateRingkasan();
        }
    }

        document.querySelectorAll('.jumlah-barang').forEach(function (input) {
        input.addEventListener('input', function () {
            // Cegah input negatif
            if (parseInt(this.value) < 0) {
                this.value = 0; // Set ke 0 jika pengguna mencoba memasukkan angka negatif
            }
        });
    });


    // Fungsi untuk memperbarui ringkasan
function updateRingkasan() {
    let subtotal = 0;

    // Hitung subtotal dari barang yang dipilih
    document.querySelectorAll('.barang-row').forEach((row, index) => {
        const barangSelect = row.querySelector('.barang-select');
        const hargaInput = row.querySelector('.harga-satuan');
        const jumlahInput = row.querySelector('.jumlah-barang');

        if (barangSelect && hargaInput && jumlahInput) {
            const selectedOption = barangSelect.selectedOptions[0];
            const harga = selectedOption ? parseFloat(selectedOption.getAttribute('data-harga')) || 0 : 0;
            const jumlah = parseFloat(jumlahInput.value) || 0;

            hargaInput.value = harga; // Perbarui harga satuan jika ada perubahan
            subtotal += harga * jumlah;
        }
    });

    // Ambil nilai PPN dari input PPN
    const ppnPercentage = parseFloat(document.getElementById('ppnInput').value) || 0;
    const ppn = (subtotal * ppnPercentage) / 100; // Hitung PPN berdasarkan persentase

    // Ambil nilai diskon
    const discountPercentage = parseFloat(document.getElementById('discountInput').value) || 0;
    const discount = (subtotal * discountPercentage) / 100; // Hitung diskon berdasarkan persentase


    // Total = subtotal + PPN - diskon
    const total = subtotal + ppn - discount;

    // Ambil jumlah bayar
    const paymentAmount = parseFloat(document.getElementById('paymentInput').value) || 0;

    // Hitung kembalian
    const change = Math.max(0, paymentAmount - total);

    // Update UI untuk ringkasan
    document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString()}`;
    document.getElementById('ppn').textContent = `Rp ${ppn.toLocaleString()}`;
    document.getElementById('discount').textContent = `Rp ${discount.toLocaleString()}`;
    document.getElementById('total').textContent = `Rp ${total.toLocaleString()}`;
    document.getElementById('payment').textContent = `Rp ${paymentAmount.toLocaleString()}`;
    document.getElementById('change').textContent = paymentAmount >= total ? `Rp ${change.toLocaleString()}` : '-';
}

// Event listener untuk PPN input
document.getElementById('ppnInput').addEventListener('input', updateRingkasan);

// Add event listeners for new inputs
document.getElementById('discountInput').addEventListener('input', updateRingkasan);
document.getElementById('paymentInput').addEventListener('input', updateRingkasan);

// Event listener untuk barang dan jumlah barang
document.querySelectorAll('.barang-select').forEach(select => {
    select.addEventListener('change', updateRingkasan);
});
document.querySelectorAll('.jumlah-barang').forEach(input => {
    input.addEventListener('input', updateRingkasan);
});
document.querySelectorAll('.plus-qty').forEach(button => {
    button.addEventListener('click', incrementQty);
});
document.querySelectorAll('.minus-qty').forEach(button => {
    button.addEventListener('click', decrementQty);
});



</script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Cari Barang",
            allowClear: true
        });
    });

    // Re-initialize Select2 setiap kali elemen baru ditambahkan
    document.getElementById('add-new-barang').addEventListener('click', function () {
        setTimeout(() => {
            $('.select2').select2({
                placeholder: "Cari Barang",
                allowClear: true
            });
        }, 100);
    });
</script>
<script>
    // Script untuk memuat data detail pengadaan ke modal
    document.addEventListener('DOMContentLoaded', function () {
        const detailButtons = document.querySelectorAll('[data-bs-target="#detailModal"]');
        detailButtons.forEach(button => {
            button.addEventListener('click', function () {
                const idPengadaan = button.getAttribute('data-idpengadaan');
                fetch(`{{ url('/pengadaan/detail') }}/${idPengadaan}`)
                    .then(response => response.json())
                    .then(data => {
                        let content = `
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah Pesan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;
                        data.forEach(item => {
                            content += `
                                <tr>
                                    <td>${item.nama_barang}</td>
                                    <td>${item.harga_satuan}</td>
                                    <td>${item.jumlah}</td>
                                    <td>${item.sub_total}</td>
                                </tr>
                            `;
                        });
                        content += `</tbody></table>`;
                        document.getElementById('detailContent').innerHTML = content;
                    })
                    .catch(error => {
                        document.getElementById('detailContent').innerHTML = `
                            <div class="alert alert-danger">Gagal memuat data.</div>
                        `;
                    });
            });
        });
    });
</script>

@endsection
