<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Famouslocations extends Model
{
     public $table = 'famouslocations';
    public $timestamps = true;

    protected $fillable = ['name', 'desc', 'photo'
                            ,'gp_name_in_url',
                            'gp_user_id'];

}
