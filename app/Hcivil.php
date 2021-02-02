<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hcivil extends Model
{
    protected $fillable = ['id','week','date', 'area', 'progress'];
}