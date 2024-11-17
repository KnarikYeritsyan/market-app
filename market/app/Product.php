<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;
    protected $fillable = [
        'name','slug','price','sale','aroma','type','volume','description',
        'category_id','brand_id','tag_id','image_name','image_name_resize'
    ];
    public $translatable = ['name','description'];

    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }

    public function tag()
    {
        return $this->belongsTo('App\Tag','tag_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage','product_id')->orderBy('sort_order');
    }

    public function options()
    {
        return $this->hasMany('App\ProductType','product_id')->orderBy('type','desc');
    }

    public function related_products()
    {
        return $this->belongsToMany(self::class,'related_products','product_id','related_product_id')->withTimestamps();
    }

}
