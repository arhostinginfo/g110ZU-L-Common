<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frontwebsitecontact extends Model
{

    public $table = 'frontwebsitecontacts';
    public $timestamps = true;

    protected $fillable = ['name', 'email', 'message','mobile_no'];

}
