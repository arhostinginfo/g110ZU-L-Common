<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
     public $table = 'sliders';
    public $timestamps = true;

    protected $fillable = ['name','photo'];

}
