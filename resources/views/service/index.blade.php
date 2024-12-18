@extends('layouts.index')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="toolbar" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Kasir Service</h1>
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

                            <form id="kasirForm" action="{{ route('service.store') }}" method="POST">
                                @csrf
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <h3 class="mb-4">Informasi Pelanggan</h3>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="no_telp" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                                        <input type="text" class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="no_pol" class="form-label">Nomor Polisi</label>
                                        <input type="text" class="form-control" id="no_pol" name="no_pol" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="id_mekanik" class="form-label">Pilih Mekanik</label>
                                        <select class="form-select" id="id_mekanik" name="id_mekanik" required>
                                            <option value="">-- Pilih Mekanik --</option>
                                            @foreach ($mekaniks as $mekanik)
                                                <option value="{{ $mekanik->id_karyawan }}">{{ $mekanik->nama_karyawan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-12 d-flex justify-content-between align-items-center mb-4">
                                        <h3>Layanan dan Barang</h3>
                                        <div>
                                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#layananModal">
                                                Tambah Layanan
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#barangModal">
                                                Tambah Barang
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="selected-items" class="mb-4">
                                            <!-- Selected items will be displayed here -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-md-3">
                                        <label for="ppnInput" class="form-label">PPN (%)</label>
                                        <input type="number" class="form-control" id="ppnInput" name="ppn" value="0" min="0" max="100" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="discountInput" class="form-label">Diskon (%)</label>
                                        <input type="number" class="form-control" id="discountInput" name="discount" value="0" min="0" max="100" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="1"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <h5>Ringkasan Layanan</h5>
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
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Pembayaran</h5>
                                        <div class="mb-3">
                                            <label for="paymentInput" class="form-label">Jumlah Bayar (Rp)</label>
                                            <input type="number" class="form-control" id="paymentInput" name="payment" value="0" min="0" required>
                                        </div>
                                        <ul class="list-group">
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
                                </div>

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

<!-- Layanan Modal -->
<div class="modal fade" id="layananModal" tabindex="-1" aria-labelledby="layananModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="layananModalLabel">Tambah Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="layananSelect" class="form-label">Pilih Layanan</label>
                    <select class="form-select" id="layananSelect">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach ($layanans as $layanan)
                            <option value="{{ $layanan->id_layanan }}" data-harga="{{ $layanan->harga_layanan }}">{{ $layanan->nama_layanan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="layananJumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="layananJumlah" value="1" min="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="tambahLayanan">Tambah</button>
            </div>
        </div>
    </div>
</div>

<!-- Barang Modal -->
<div class="modal fade" id="barangModal" tabindex="-1" aria-labelledby="barangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barangModalLabel">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="barangSelect" class="form-label">Pilih Barang</label>
                    <select class="form-select" id="barangSelect">
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barangs as $barang)
                            <option value="{{ $barang->idbarang }}" data-harga="{{ $barang->harga }}">{{ $barang->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="barangJumlah" class="form-label">Jumlah</label>
                    <input type="number" class="form-control" id="barangJumlah" value="1" min="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="tambahBarang">Tambah</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {
    let selectedItems = [];

    function updateSelectedItems() {
        const container = document.getElementById('selected-items');
        container.innerHTML = '';

        selectedItems.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'mb-2');
            itemElement.innerHTML = `
                <span>${item.name} - ${item.jumlah} x Rp ${item.harga.toLocaleString()}</span>
                <button type="button" class="btn btn-sm btn-danger remove-item" data-index="${index}">Hapus</button>
            `;
            container.appendChild(itemElement);
        });

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                selectedItems.splice(index, 1);
                updateSelectedItems();
                updateRingkasan();
            });
        });

        updateRingkasan();
    }

    function addItem(type) {
        const select = document.getElementById(type === 'layanan' ? 'layananSelect' : 'barangSelect');
        const jumlahInput = document.getElementById(type === 'layanan' ? 'layananJumlah' : 'barangJumlah');
        const selectedOption = select.selectedOptions[0];

        if (selectedOption && jumlahInput.value > 0) {
            const item = {
                id: selectedOption.value,
                name: selectedOption.text,
                harga: parseFloat(selectedOption.getAttribute('data-harga')),
                jumlah: parseInt(jumlahInput.value),
                type: type
            };

            selectedItems.push(item);
            updateSelectedItems();

            // Reset modal inputs
            select.value = '';
            jumlahInput.value = 1;

            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById(`${type}Modal`));
            modal.hide();
        }
    }

    document.getElementById('tambahLayanan').addEventListener('click', () => addItem('layanan'));
    document.getElementById('tambahBarang').addEventListener('click', () => addItem('barang'));

    function updateRingkasan() {
        let subtotal = selectedItems.reduce((total, item) => total + (item.harga * item.jumlah), 0);

        const ppnPercentage = parseFloat(document.getElementById('ppnInput').value) || 0;
        const ppn = (subtotal * ppnPercentage) / 100;

        const discountPercentage = parseFloat(document.getElementById('discountInput').value) || 0;
        const discount = (subtotal * discountPercentage) / 100;

        const total = subtotal + ppn - discount;

        const paymentAmount = parseFloat(document.getElementById('paymentInput').value) || 0;
        const change = Math.max(0, paymentAmount - total);

        document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString()}`;
        document.getElementById('ppn').textContent = `Rp ${ppn.toLocaleString()}`;
        document.getElementById('discount').textContent = `Rp ${discount.toLocaleString()}`;
        document.getElementById('total').textContent = `Rp ${total.toLocaleString()}`;
        document.getElementById('payment').textContent = `Rp ${paymentAmount.toLocaleString()}`;
        document.getElementById('change').textContent = paymentAmount >= total ? `Rp ${change.toLocaleString()}` : '-';
    }

    document.getElementById('ppnInput').addEventListener('input', updateRingkasan);
    document.getElementById('discountInput').addEventListener('input', updateRingkasan);
    document.getElementById('paymentInput').addEventListener('input', updateRingkasan);

    // Form submission
    document.getElementById('kasirForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Add selected items to the form
        selectedItems.forEach((item, index) => {
            const itemType = item.type === 'layanan' ? 'id_layanan' : 'id_barang';
            const itemInput = document.createElement('input');
            itemInput.type = 'hidden';
            itemInput.name = `items[${index}][${itemType}]`;
            itemInput.value = item.id;
            this.appendChild(itemInput);

            const jumlahInput = document.createElement('input');
            jumlahInput.type = 'hidden';
            jumlahInput.name = `items[${index}][jumlah]`;
            jumlahInput.value = item.jumlah;
            this.appendChild(jumlahInput);
        });

        // Submit the form
        this.submit();
    });

    updateRingkasan();
});


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
@endsection

