<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = [
        'invoice_no',
        'customer_id',
        'sale_date',
        'total_amount',
        'paid_amount',
        'due_amount',
        'discount_amount',
        'tax_amount',
        'payment_status',
        'payment_method',
        'notes',
        'created_by',
    ];

    // Sale belongs to customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Sale has many items
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Sale created by user (cashier/admin)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
