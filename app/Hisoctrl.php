<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hisoctrl extends Model
{
    protected $fillable = ['filename','revision','tie','spo','sit','requested','requestedlead','issued','deleted','claimed','verifydesign','verifystress','verifysupports','fromldgsupports','from', 'to', 'comments', 'user' ];
}
