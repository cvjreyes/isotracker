<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diameter extends Model
{
    public $fillable = ['id','nps','dn'];
}