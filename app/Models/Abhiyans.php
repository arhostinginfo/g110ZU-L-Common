<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abhiyans extends Model
{
    public $table = 'abhiyans';
    public $timestamps = true;

    protected $fillable = ['abhiyan_name', 'abhiyan_date'
                            ,'gp_name_in_url',
                            'gp_user_id'];
}
