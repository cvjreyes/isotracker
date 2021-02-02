<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dcivilsnew extends Model
{
    protected $fillable = ['id', 'units_id', 'areas_id', 'tcivils_id', 'tag', 'pcivils_id'];
}
