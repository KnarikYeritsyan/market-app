<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title','content','image_name','image_name_resize','slug','status','meta_description','meta_keywords'
    ];

    public function getTitleAttribute()
    {
        return json_decode($this->attributes['title'])->{app()->getLocale()};
    }

    public function getContentAttribute()
    {
        return json_decode($this->attributes['content'])->{app()->getLocale()};
    }

    public function getMetaDescriptionAttribute()
    {
        return json_decode($this->attributes['meta_description'])->{app()->getLocale()};
    }

    public function getMetaKeywordsAttribute()
    {
        return json_decode($this->attributes['meta_keywords'])->{app()->getLocale()};
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
