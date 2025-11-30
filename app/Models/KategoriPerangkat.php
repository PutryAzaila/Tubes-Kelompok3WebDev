<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPerangkat extends Model
{
    protected $table = 'kategori_perangkats';

    protected $fillable = [
        'nama_kategori'
    ];

    // KategoriPerangkat -> Perangkat (One to Many)
    public function perangkats()
    {
        return $this->hasMany(Perangkat::class, 'id_kategori_perangkat');
    }
}
