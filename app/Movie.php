<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
  protected $table = 'movies';
  protected $fillable = ['name', 'description'];
  protected $guarded = ['id']
}
