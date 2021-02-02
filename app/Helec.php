<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helec extends Model
{
    protected $fillable = ['id','week','date', 'area', 'progress'];
}