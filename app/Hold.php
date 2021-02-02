<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hold extends Model
{
    public $fillable = ['id','dpipesnews_id','holds','description'];
}