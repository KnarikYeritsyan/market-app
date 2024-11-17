<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Brand extends Model
{
    use HasTranslations;
    protected $fillable = [
        'name','slug','description','excerpt','image_name','image_name_resize'
    ];
    public $translatable = ['description','excerpt'];

    public function products()
    {
        return $this->hasMany('App\Product','brand_id')->orderBy('created_at','desc');
    }
}
