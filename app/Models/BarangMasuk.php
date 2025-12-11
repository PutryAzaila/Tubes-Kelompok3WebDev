<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuks';

    protected $fillable = [
        'id_perangkat',
        'status',
        'jumlah',
        'tanggal',
        'catatan_barang_masuk',
    ];

    // BarangMasuk -> Perangkat (One to One)
    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class, 'id_perangkat');
    }
}
