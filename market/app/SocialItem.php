<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialItem extends Model
{
    protected $fillable = [
        'status','title','link','type'
    ];
}
