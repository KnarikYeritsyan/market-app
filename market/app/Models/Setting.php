<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $fillable = [
        'key','display_name','value','type','group','name'
    ];

    public function getDisplayNameAttribute()
    {
        return json_decode($this->attributes['display_name'])->{app()->getLocale()};
    }

    public function getValueAttribute()
    {
        return isset(json_decode($this->attributes['value'])->{app()->getLocale()})?json_decode($this->attributes['value'])->{app()->getLocale()}:'';
    }
}
