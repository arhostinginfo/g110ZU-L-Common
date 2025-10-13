<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frontwebsitecontact extends Model
{

    public $table = 'frontwebsitecontacts';
    public $timestamps = true;

    protected $fillable = ['name', 'email', 'message','mobile_no'
                            ,'gp_name_in_url',
                            'gp_user_id'];

}
