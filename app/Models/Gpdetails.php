<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gpdetails extends Model
{
    public $table = 'gpdetails';
    public $timestamps = true;

    protected $fillable = [
        'employee_email',
           'employee_password',
           'gp_under_district',
           'gp_under_taluka',
           'gp_name',
           'gp_name_in_url',
           'gp_valid_till',

    ];
}
