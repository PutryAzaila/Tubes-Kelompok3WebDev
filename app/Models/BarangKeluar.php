<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'barang_keluars';

    protected $fillable = [
        'id_perangkat',
        'jumlah',
        'tanggal',
        'alamat',
        'status',
        'catatan_barang_keluar',
    ];

    // BarangKeluar -> Perangkat (One to One)
    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class, 'id_perangkat');
    }
}
