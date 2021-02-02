<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disoctrl extends Model
{
    protected $fillable = ['isostatus_id','filename','progress','progressreal','progressmax','issuedfolder','issuedate','revision','deleted','ddesign','instress','dstress','insupports','dsupports','inmaterials','dmaterials','inlead','dlead','iniso','diso'];
}
