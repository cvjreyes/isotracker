<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dstation extends Model
{
    protected $fillable = ['zone_name', 'item_name', 'item_type', 'status_station'];
}
