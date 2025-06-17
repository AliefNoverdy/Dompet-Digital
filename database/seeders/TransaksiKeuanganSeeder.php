<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('transaksi_keuangan')->insert([
            [
                'user_id' => 1, // pastikan user ini sudah ada
                'kategori_id' => 1, // "Makan"
                'tipe_transaksi' => 'pengeluaran',
                'nominal' => 50000,
                'deskripsi' => 'Beli makan siang',
                'tanggal_transaksi' => '2025-05-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'kategori_id' => 3, // "Gaji"
                'tipe_transaksi' => 'pemasukan',
                'nominal' => 2000000,
                'deskripsi' => 'Gaji freelance',
                'tanggal_transaksi' => '2025-05-02',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
