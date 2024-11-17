<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id','image_name','image_name_resize','sort_order'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function getImageNameAttribute()
    {
        return env('APP_URL').$this->attributes['image_name'];
    }

    public function getImageNameResizeAttribute()
    {
        return env('APP_URL').$this->attributes['image_name_resize'];
    }
}
