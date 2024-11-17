<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name','color','slug'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product','tag_id')->orderBy('created_at','desc');
    }

    public function products_4()
    {
        return $this->hasMany('App\Models\Product','tag_id')->orderBy('created_at','desc')->take(10);
    }

    public function getNameAttribute()
    {
        return json_decode($this->attributes['name'])->{app()->getLocale()};
    }
}
