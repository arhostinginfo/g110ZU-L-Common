<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    public $table = 'employees';
    public $timestamps = true;

    protected $fillable = ['employee_email', 'employee_password'];
}
