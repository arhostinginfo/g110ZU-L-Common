<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marquees extends Model
{
    public $table = 'marquees';
    public $timestamps = true;

    protected $fillable = ['message'
                            ,'gp_name_in_url',
                            'gp_user_id'];
}
