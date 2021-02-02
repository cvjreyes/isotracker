<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delecsnew extends Model
{
    protected $fillable = ['id', 'units_id', 'areas_id', 'telecs_id', 'tag', 'pelecs_id'];
}
