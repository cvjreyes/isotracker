<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    //public $fillable = ['title','description'];
    public $fillable = ['name','type','qty','hours','weight'];


}