<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpipe extends Model
{
    protected $fillable = ['zone_name', 'pipe_name', 'pid', 'iso', 'stress', 'support', 'pdms_linenumber'];
}
