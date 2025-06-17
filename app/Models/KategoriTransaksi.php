<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriTransaksi extends Model
{
    protected $table    = 'kategori_transaksi';
    protected $fillable = ['nama_kategori'];

    public function transaksi()
    {
        return $this->hasMany(TransaksiKeuangan::class, 'kategori_id');
    }
}
