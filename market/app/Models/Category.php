<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name','description','image_name','image_name_resize','slug'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product','category_id')->where('status',1)->orderBy('created_at','desc');
    }

    public function getNameAttribute()
    {
        return json_decode($this->attributes['name'])->{app()->getLocale()};
    }

    public function getDescriptionAttribute()
    {
        return json_decode($this->attributes['description'])->{app()->getLocale()};
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
