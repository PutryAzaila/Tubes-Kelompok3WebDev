<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $fillable = [
        'detail_barang_id',
        'jumlah',
        'tanggal',
        'alamat',
        'status',
        'catatan_barang_keluar'
    ];

    public function detailBarang()
    {
        return $this->belongsTo(DetailBarang::class);
    }
}
