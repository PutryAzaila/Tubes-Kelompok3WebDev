<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    protected $fillable = [
        'id_perangkat',
        'serial_number',
        'kategori',
        'mac_address'
    ];

    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class, 'id_perangkat');
    }

    public function barangMasuk()
    {
        return $this->hasOne(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasOne(BarangKeluar::class);
    }
}
