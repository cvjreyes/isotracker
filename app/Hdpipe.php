<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hdpipe extends Model
{
    protected $fillable = ['date', 'pid', 'iso', 'stress', 'support', 'pdms_linenumber'];
}
