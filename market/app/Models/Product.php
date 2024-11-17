<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','slug','price','sale','aroma','type','volume','description',
        'category_id','brand_id','tag_id','image_name','image_name_resize'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function tag()
    {
        return $this->belongsTo('App\Models\Tag','tag_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage','product_id')->orderBy('sort_order');
    }

    public function getNameAttribute()
    {
        return json_decode($this->attributes['name'])->{app()->getLocale()};
    }

    public function getDescriptionAttribute()
    {
        return json_decode($this->attributes['description'])->{app()->getLocale()};
    }

    public function getSlugAttribute()
    {
        return '/shop/'.Category::find($this->attributes['category_id'])->slug.'/'.$this->attributes['slug'];
    }

    public function getImageNameAttribute()
    {
        return env('APP_URL').$this->attributes['image_name'];
    }

    public function getImageNameResizeAttribute()
    {
        return env('APP_URL').$this->attributes['image_name_resize'];
    }

    public function related_products()
    {
        return $this->belongsToMany(self::class,'related_products','product_id','related_product_id')->withTimestamps();
    }
}
