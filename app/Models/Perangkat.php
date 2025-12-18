<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    protected $table = 'perangkats';

    protected $fillable = [
        'id_kategori_perangkat',
        'nama_perangkat',
        'status',
        'catatan_perangkat',
    ];

    // Perangkat -> KategoriPerangkat (Many to One)
    public function kategoriPerangkat()
    {
        return $this->belongsTo(KategoriPerangkat::class, 'id_kategori_perangkat');
    }

    // Perangkat -> DetailPurchaseOrder (One to Many)
    public function detailPO()
    {
        return $this->hasMany(DetailPurchaseOrder::class, 'id_perangkat');
    }

    // Perangkat -> BarangMasuk (One to One)
    public function barangMasuk()
    {
        return $this->hasOne(BarangMasuk::class, 'id_perangkat');
    }

    // Perangkat -> BarangKeluar (One to One)
    public function barangKeluar()
    {
        return $this->hasOne(BarangKeluar::class, 'id_perangkat');
    }
}
