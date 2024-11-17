<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $fillable = [
        'product_id','type','price','quantity'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }
}
