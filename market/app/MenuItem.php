<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use HasTranslations;
    protected $fillable = [
        'menu_id','title','url','slug','parent_id','target','group','type','conn_id','sort_order'
    ];
    public $translatable = ['title'];

    public function child_menu()
    {
        return $this->hasMany(self::class,'parent_id')->orderBy('sort_order');
    }

    public function parent_menu()
    {
        return $this->belongsTo(self::class,'parent_id','id');
    }

    public function children()
    {
        return $this->child_menu()->with('children');
    }

    public function children1()
    {
        return $this->hasMany(self::class,'parent_id')->with('child_menu');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($menu) {
            foreach($menu->children as $child){
                $child->delete();
            }
        });
    }
}
