<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pmanager extends Model
{
    protected $fillable = ['name', 'weight','quantity','multiplier','start', 'end','weeks','startweek','locked','feed','per_feed','weight_total'];
}
