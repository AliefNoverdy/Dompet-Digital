<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiKeuangan;
use App\Models\KategoriTransaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiKeuanganController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiKeuangan::with('kategori')->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        // kirim semua kategori ke view
        $kategori = KategoriTransaksi::orderBy('nama_kategori')->get();
        return view('transaksi.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id'      => 'required|exists:kategori_transaksi,id',
            'tipe_transaksi'   => 'required|in:pemasukan,pengeluaran',
            'nominal'          => 'required|numeric|min:1',
            'tanggal_transaksi' => 'required|date',
            'deskripsi'        => 'nullable|string',
        ]);

        // tambahkan user_id & tanggal_transaksi
        $validated['user_id']          = Auth::id();
        TransaksiKeuangan::create($validated); // ✅ tanggal_transaksi biarkan dari input form

        return redirect()->route('dashboard')
                         ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit(TransaksiKeuangan $transaksi)
    {
        $kategori = KategoriTransaksi::orderBy('nama_kategori')->get();
        return view('transaksi.edit', compact('transaksi', 'kategori'));
    }

    public function update(Request $request, TransaksiKeuangan $transaksi)
    {
        $validated = $request->validate([
            'kategori_id'    => 'required|exists:kategori_transaksi,id',
            'tipe_transaksi' => 'required|in:pemasukan,pengeluaran',
            'nominal'        => 'required|numeric|min:1',
            'tanggal_transaksi' => 'required|date',
            'deskripsi'      => 'nullable|string',
        ]);

        $transaksi->update($validated);

        return redirect()->route('transaksi.index')
                         ->with('success', 'Transaksi berhasil diupdate.');
    }

    public function destroy(TransaksiKeuangan $transaksi, Request $request)
    {
        $transaksi->delete();

        // Cek apakah penghapusan berasal dari dashboard
        if ($request->from_dashboard) {
            return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus.');
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

}
