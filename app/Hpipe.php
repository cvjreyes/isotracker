<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hpipe extends Model
{
    protected $fillable = ['id','week','date', 'area', 'progress'];
}