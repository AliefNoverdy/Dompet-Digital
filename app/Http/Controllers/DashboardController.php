<?php

namespace App\Http\Controllers;

use App\Models\TransaksiKeuangan;
use App\Models\KategoriTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan ringkasan dashboard.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $tipeFilter = $request->query('tipe');

        $totalPemasukan = TransaksiKeuangan::where('user_id', $userId)
            ->where('tipe_transaksi', 'pemasukan')
            ->sum('nominal');

        $totalPengeluaran = TransaksiKeuangan::where('user_id', $userId)
            ->where('tipe_transaksi', 'pengeluaran')
            ->sum('nominal');

        $saldo = $totalPemasukan - $totalPengeluaran;

        $transaksiQuery = TransaksiKeuangan::with('kategori')
            ->where('user_id', $userId)
            ->latest('tanggal_transaksi');

        if (in_array($tipeFilter, ['pemasukan', 'pengeluaran'])) {
            $transaksiQuery->where('tipe_transaksi', $tipeFilter);
        }

        $transaksiTerbaru = $transaksiQuery->take(10)->get();
        $semuaKategori = KategoriTransaksi::orderBy('nama_kategori')->get();

        return view('dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'transaksiTerbaru',
            'semuaKategori'
        ));
    }

    /**
     * Handle update inline transaksi (AJAX).
     */
    public function updateInline(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_transaksis,id',
            'deskripsi' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
        ]);

        $transaksi = TransaksiKeuangan::where('user_id', Auth::id())->findOrFail($id);

        $transaksi->kategori_id = $request->kategori_id;
        $transaksi->deskripsi = $request->deskripsi;
        $transaksi->nominal = $request->nominal;
        $transaksi->save();

        return response()->json(['status' => 'ok']);
    }
}
