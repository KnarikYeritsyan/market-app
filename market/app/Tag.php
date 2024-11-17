<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasTranslations;
    protected $fillable = [
        'name','color','slug'
    ];
    public $translatable = ['name'];

    public function products()
    {
        return $this->hasMany('App\Product','tag_id')->orderBy('created_at','desc');
    }
}
