@extends('layout')

@section('title', 'Dashboard')

@section('content')
<!-- Bootstrap 5 CDN & Font Awesome (hanya jika belum ada di layout.blade.php) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<h3 class="mb-4">Ringkasan Keuangan</h3>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ url('dashboard?tipe=pemasukan') }}" class="text-decoration-none">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-down fa-2x mb-2"></i>
                    <h6>Total Pemasukan</h6>
                    <h4>Rp {{ number_format($totalPemasukan,0,',','.') }}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ url('dashboard?tipe=pengeluaran') }}" class="text-decoration-none">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-arrow-up fa-2x mb-2"></i>
                    <h6>Total Pengeluaran</h6>
                    <h4>Rp {{ number_format($totalPengeluaran,0,',','.') }}</h4>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-wallet fa-2x mb-2"></i>
                <h6>Saldo Saat Ini</h6>
                <h4>Rp {{ number_format($saldo,0,',','.') }}</h4>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Transaksi
</a>

@if(request('tipe'))
    <a href="{{ url('dashboard') }}" class="btn btn-outline-secondary mb-3 ms-2">
        <i class="fas fa-list"></i> Tampilkan Semua Transaksi
    </a>
@endif

@if(isset($transaksiTerbaru) && $transaksiTerbaru->count())
    <div class="card">
        <div class="card-header fw-semibold">
            @if(request('tipe') == 'pemasukan')
                10 Transaksi Pemasukan Terbaru
            @elseif(request('tipe') == 'pengeluaran')
                10 Transaksi Pengeluaran Terbaru
            @else
                10 Transaksi Terbaru
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:140px">Tanggal</th>
                            <th>Kategori</th>
                            <th style="width:130px">Tipe</th>
                            <th>Deskripsi</th>
                            <th class="text-end" style="width:170px">Nominal</th>
                            <th style="width:200px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksiTerbaru as $trx)
                        <tr data-id="{{ $trx->id }}">
                            <td>{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M Y') }}</td>
                            <td>
                                <span class="view-mode">{{ $trx->kategori->nama_kategori ?? '-' }}</span>
                                <select name="kategori_id" class="form-select form-select-sm edit-mode d-none">
                                    @foreach($semuaKategori as $kategori)
                                        <option value="{{ $kategori->id }}" @selected($kategori->id == $trx->kategori_id)>{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-capitalize">{{ $trx->tipe_transaksi }}</td>
                            <td>
                                <span class="view-mode">{{ $trx->deskripsi ?? '-' }}</span>
                                <input type="text" name="deskripsi" class="form-control form-control-sm edit-mode d-none" value="{{ $trx->deskripsi }}">
                            </td>
                            <td class="text-end">
                                <span class="view-mode">Rp {{ number_format($trx->nominal, 0, ',', '.') }}</span>
                                <input type="number" name="nominal" class="form-control form-control-sm text-end edit-mode d-none" value="{{ $trx->nominal }}">
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('transaksi.edit', $trx->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <button type="button" class="btn btn-sm btn-success d-none btn-simpan">Simpan</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <p class="mt-4 text-muted">Belum ada transaksi yang tercatat.</p>
@endif
@endsection
