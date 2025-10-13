<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $table = 'admin';
    public $timestamps = true;

    protected $fillable = ['employee_email', 'employee_password'];
}
