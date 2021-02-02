<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tpipe extends Model
{
    public $fillable = ['id','name','hours','code','pid','iso','stress','support'];
}