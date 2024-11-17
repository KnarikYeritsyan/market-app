<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title','description','image_name','image_name_resize','slug','status'
    ];

    public function getTitleAttribute()
    {
        return json_decode($this->attributes['title'])->{app()->getLocale()};
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
