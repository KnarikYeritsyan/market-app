<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_id','title','url','slug','parent_id','target','group','type','conn_id','sort_order'
    ];

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

    public function getTitleAttribute()
    {
        return json_decode($this->attributes['title'])->{app()->getLocale()};
    }

    public function getSlugAttribute()
    {
        if ($this->attributes['group'] == 'page')
        {
            return '/'.$this->page->slug;
        }
        if ($this->attributes['group'] == 'shop')
        {
            if ($this->attributes['type'] == 'category'){
                return '/shop/'.$this->category->slug;
            }else{
                return '/shop';
            }
        }
        if ($this->attributes['group'] == 'categories')
        {
            if ($this->attributes['type'] == 'category'){
                return '/shop/'.$this->category->slug;
            }else{
                return '/categories';
            }
        }
        if ($this->attributes['group'] == 'brand')
        {
            if ($this->attributes['type'] == 'brand'){
                return '/brand/'.$this->brand->slug;
            }else{
                return '/brands';
            }
        }
        if ($this->attributes['group'] == 'tag')
        {
            if ($this->attributes['type'] == 'tag'){
                return '/tag/'.$this->tag->slug;
            }else{
                return '/tags';
            }
        }
        if ($this->attributes['group'] == 'custom_link')
        {
            return $this->attributes['url'];
        }
    }

    public function page()
    {
        return $this->belongsTo('App\Models\Page','conn_id','id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category','conn_id','id');
    }
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','conn_id','id');
    }
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag','conn_id','id');
    }
}
