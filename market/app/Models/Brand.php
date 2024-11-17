<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name','slug','description','excerpt','image_name','image_name_resize'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product','brand_id')->orderBy('created_at','desc')->with('tag');
    }

    public function getDescriptionAttribute()
    {
        return json_decode($this->attributes['description'])->{app()->getLocale()};
    }

    public function getExcerptAttribute()
    {
        return json_decode($this->attributes['excerpt'])->{app()->getLocale()};
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
