<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';

    protected $fillable = [
        'id_vendor',
        'id_karyawan',
        'tanggal_pemesanan',
        'status',
    ];

    // PurchaseOrder -> DataVendor (Many to One)
    public function vendor()
    {
        return $this->belongsTo(DataVendor::class, 'id_vendor');
    }

    // PurchaseOrder -> User (Many to One)
    public function karyawan()
    {
        return $this->belongsTo(User::class, 'id_karyawan');
    }

    // PurchaseOrder -> DetailPurchaseOrder (One to Many)
    public function detailPO()
    {
        return $this->hasMany(DetailPurchaseOrder::class, 'id_po');
    }
}
