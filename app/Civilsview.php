<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class civilsview extends Model
{
    public $fillable = ['type','code','hours','area','est_quantity','est_hours'];


}