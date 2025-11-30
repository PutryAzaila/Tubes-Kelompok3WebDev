<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriVendor extends Model
{
    protected $table = 'kategori_vendors';

    protected $fillable = [
        'nama_kategori'
    ];

    // KategoriVendor -> DataVendor (One to Many)
    public function vendors()
    {
        return $this->hasMany(DataVendor::class, 'id_kategori_vendor');
    }
}
