<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telec extends Model
{
    public $fillable = ['id','name','hours','code'];
}