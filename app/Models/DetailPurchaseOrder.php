<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPurchaseOrder extends Model
{
    protected $table = 'detail_purchase_orders';

    protected $fillable = [
        'id_po',
        'id_perangkat',
        'jumlah',
    ];

    // DetailPurchaseOrder -> PurchaseOrder (Many to One)
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'id_po');
    }

    // DetailPurchaseOrder -> Perangkat (Many to One)
    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class, 'id_perangkat');
    }
}
