<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Misoctrl extends Model
{
    protected $fillable = ['filename','isoid','revision','tie','spo','sit','requested','requestedlead','issued','deleted','hold','claimed','verifydesign','verifystress','verifysupports','fromldgsupports','from', 'to', 'comments', 'user' ];
}
