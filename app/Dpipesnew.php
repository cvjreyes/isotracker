<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpipesnew extends Model
{
    protected $fillable = ['id', 'units_id', 'areas_id', 'tag', 'diameters_id','calc_notes','ppipe_pids_id','ppipe_isos_id','ppipe_stresses_id','ppipe_supports_id'];
}
