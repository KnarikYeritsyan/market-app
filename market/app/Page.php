<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;
    protected $fillable = [
        'title','content','image_name','image_name_resize','slug','status','meta_description','meta_keywords'
    ];
    public $translatable = ['title','content','meta_description','meta_keywords'];
}
