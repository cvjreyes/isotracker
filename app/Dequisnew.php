<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dequisnew extends Model
{
    protected $fillable = ['id', 'units_id', 'areas_id', 'tequis_id', 'tag', 'pequis_id'];
}
