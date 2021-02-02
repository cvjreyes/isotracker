<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Einst extends Model
{
    public $fillable = ['id','units_id','telecs_id','tag','hours','est_qty'];


}