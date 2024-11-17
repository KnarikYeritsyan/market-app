<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasTranslations;
    protected $fillable = [
        'title','description','image_name','image_name_resize','slug','status'
    ];
    public $translatable = ['title','description'];
}
