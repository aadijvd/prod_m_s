<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    // Fields allowed for mass assignment
    protected $fillable = [
        'purchase_id', // links to purchase
        'product_id',  // which product was bought
        'qty',         // quantity purchased
        'price',       // price per unit
        'subtotal',    // qty * price
    ];








    // Each item belongs to ONE purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // Each item is linked to ONE product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
