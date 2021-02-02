<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tequi extends Model
{
    public $fillable = ['id','name','hours','code'];
}