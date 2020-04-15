<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    
    protected $fillable = [
        'sku',
        'name',
        'in_stock'
    ];

}
