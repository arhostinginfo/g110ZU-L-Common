<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navbars extends Model
{
    public $table = 'navbars';
    public $timestamps = true;


    	
        protected $fillable = ['footer_desc',
              'address',
              'contact_number',
              'email_id',
              'color',
              'name',
              'logo',
              'lat',
              'lon'
             ,'gp_name_in_url',
              'gp_user_id'];
}
