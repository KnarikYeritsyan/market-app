<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use HasTranslations;
    protected $fillable = [
        'name'
    ];
    public $translatable = ['name'];

    public function items()
    {
        return $this->hasMany('App\MenuItem','menu_id')->orderBy('sort_order');
    }

}
