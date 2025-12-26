<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    protected $fillable = [
        'id_perangkat',
        'serial_number',
        'kategori',
    ];

    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class, 'id_perangkat');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}
