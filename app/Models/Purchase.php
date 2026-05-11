<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    // Fields allowed for mass assignment
    protected $fillable = [
        'supplier_id',     // who you bought from
        'total_amount',    // total bill amount
        'purchase_date',   // date of purchase
        'notes',           // optional notes
    ];





    // Each purchase belongs to ONE supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // One purchase has MANY items
    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
