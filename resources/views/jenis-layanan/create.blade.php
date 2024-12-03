@extends('layouts.index')

@section('content')
<div class="content">
    <div class="container-xxl">
        <div class="card">
            <div class="card-header">
                <h3>{{ isset($jenisLayanan) ? 'Edit Jenis Layanan' : 'Tambah Jenis Layanan' }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ isset($jenisLayanan) ? route('jenis-layanan.update', $jenisLayanan->id) : route('jenis-layanan.store') }}" method="POST">
                    @csrf
                    @if(isset($jenisLayanan))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="nama_layanan" class="form-label">Nama Layanan</label>
                        <input type="text" name="nama_layanan" class="form-control" id="nama_layanan" value="{{ $jenisLayanan->nama_layanan ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control">{{ $jenisLayanan->deskripsi ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" id="harga" value="{{ $jenisLayanan->harga ?? '' }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
