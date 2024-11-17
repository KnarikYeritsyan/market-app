<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;
    protected $fillable = [
        'name','description','image_name','image_name_resize','slug'
    ];
    public $translatable = ['name','description'];

    public function products()
    {
        return $this->hasMany('App\Product','category_id')->orderBy('created_at','desc');
    }
}
