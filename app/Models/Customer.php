<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'type',
    ];

    // A customer can have many sales
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
