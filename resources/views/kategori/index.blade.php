@extends('layout')

@section('title', 'Kategori Transaksi')

@section('content')
<h3 class="mb-4">Kategori Transaksi</h3>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">+ Tambah Kategori</a>

<table class="table table-bordered table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th style="width: 50px;">No</th>
            <th>Nama Kategori</th>
            <th style="width: 130px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_kategori }}</td>
            <td>
                <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-sm btn-warning me-1" title="Edit">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" title="Hapus" type="submit">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center text-muted">Belum ada kategori.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
