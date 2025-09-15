<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Officers extends Model
{
    public $table = 'officers';
    public $timestamps = true;

    protected $fillable = ['designation','name','mobile','email','photo','type','sequence_officer','sequence_general'];
}
