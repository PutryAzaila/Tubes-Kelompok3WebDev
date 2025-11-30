<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataVendor extends Model
{
    protected $table = 'data_vendors';

    protected $fillable = [
        'id_kategori_vendor',
        'nama_vendor',
        'alamat_vendor',
        'no_telp_vendor',
        'deskripsi_vendor',
    ];

    // DataVendor -> KategoriVendor (Many to One)
    public function kategori()
    {
        return $this->belongsTo(KategoriVendor::class, 'id_kategori_vendor');
    }

    // DataVendor -> PurchaseOrder (One to Many)
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class, 'id_vendor');
    }
}
