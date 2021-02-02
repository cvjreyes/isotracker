<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mpipe extends Model
{
    protected $fillable = ['id','week', 'area', 'estimated'];
}