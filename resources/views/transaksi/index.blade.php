@extends('layout')

@section('title', 'Data Transaksi')

@section('content')
<div class="container-fluid px-9">
    <h3 class="mb-4 fw-bold">Data Transaksi</h3>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">+ Tambah Transaksi</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle w-100 fs-4">
            <thead class="table-light">
                <tr class="text-center">
                    <th class="py-3" style="width: 100px;">No</th>
                    <th class="py-3">Tipe</th>
                    <th class="py-3">Kategori</th>
                    <th class="py-3">Nominal</th>
                    <th class="py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $item)
                <tr>
                    <td class="py-3 text-center">{{ $loop->iteration }}</td>
                    <td class="py-3 text-center">
                        @if($item->tipe_transaksi === 'pemasukan')
                            <span class="badge bg-success text-capitalize">Pemasukan</span>
                        @else
                            <span class="badge bg-danger text-capitalize">Pengeluaran</span>
                        @endif
                    </td>
                    <td class="py-3">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td class="py-3">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td class="py-3">{{ $item->deskripsi ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Tidak ada data transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
