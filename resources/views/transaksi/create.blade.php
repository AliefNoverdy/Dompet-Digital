@extends('layout')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="fs-4">
    <h3 class="mb-4 fw-bold">Tambah Transaksi</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transaksi.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="tipe_transaksi" class="form-label">Tipe Transaksi</label>
            <select name="tipe_transaksi" id="tipe_transaksi" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="pemasukan" {{ old('tipe_transaksi') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                <option value="pengeluaran" {{ old('tipe_transaksi') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
            <div class="invalid-feedback">Tipe transaksi wajib dipilih.</div>
        </div>

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Kategori wajib dipilih.</div>
        </div>

        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="number" name="nominal" id="nominal" class="form-control" value="{{ old('nominal') }}" min="1" required>
            <div class="invalid-feedback">Nominal harus diisi dan lebih besar dari 0.</div>
        </div>

        <div class="mb-3">
            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
            <input type="date" id="tanggal_transaksi" name="tanggal_transaksi" class="form-control" value="{{ old('tanggal_transaksi', now()->format('Y-m-d')) }}" required>
            <div class="invalid-feedback">Tanggal transaksi wajib diisi.</div>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
            <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="{{ old('deskripsi') }}" placeholder="Deskripsi singkat transaksi">
        </div>

        <button type="submit" class="btn btn-primary fs-4">Simpan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary fs-4">Kembali</a>
    </form>
</div>

<script>
// Bootstrap 5 custom validation script
(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})();
</script>
@endsection
