<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = [
        'detail_barang_id',
        'jumlah',
        'tanggal',
        'status',
        'catatan_barang_masuk'
    ];

    public function detailBarang()
    {
        return $this->belongsTo(DetailBarang::class);
    }
}
