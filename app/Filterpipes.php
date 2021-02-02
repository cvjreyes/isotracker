<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filterpipes extends Model
{
    protected $fillable = ['id','field', 'operator', 'comparison'];
}
