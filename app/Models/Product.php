<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //values to be filled in db
    protected $fillable = [
        'item_name',
        'qty',
        'item_descr',
        'cost',
        'sale',
        'unit',
        'barcode',
        'image',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
