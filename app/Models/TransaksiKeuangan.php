<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeuangan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_keuangan';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'tipe_transaksi',
        'nominal',
        'deskripsi',
        'tanggal_transaksi',
    ];
    protected $casts = [
    'tanggal_transaksi' => 'date',
];

    public function kategori()
    {
        return $this->belongsTo(KategoriTransaksi::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
