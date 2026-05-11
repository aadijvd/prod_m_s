<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
    ];

    // A supplier can have MANY purchases
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
