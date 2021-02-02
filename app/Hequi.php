<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hequi extends Model
{
    protected $fillable = ['id','week','date', 'area', 'progress'];
}