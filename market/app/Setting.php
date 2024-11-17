<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    use HasTranslations;
    protected $fillable = [
        'key','display_name','value','type','group','name'
    ];
    public $translatable = ['display_name','value'];
}
