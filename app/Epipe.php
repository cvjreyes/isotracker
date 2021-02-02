<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Epipe extends Model
{
    public $fillable = ['id','units_id','areas_id','diameters_id','line_number','pdms_linenumber','calc_notes'];


}