<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
     public $table = 'sliders';
    public $timestamps = true;

    protected $fillable = ['name','photo'
                            ,'gp_name_in_url',
                            'gp_user_id'];
                            

}
