<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StocksLog extends Model
{
    const TYPE_ADD = 'add';
    const TYPE_REMOVE = 'remove';

    const ORIGIN_API = 'api';
    const ORIGIN_SITE = 'site';


    protected $fillable = [
        'before',
        'after',
        'type',
        'origin',
    ];

    public function product() {
        return $this->belongsTo('App\Model\Product');
    }
}
