<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'ip','name','email','subject','message','seen','clicked'
    ];
}
