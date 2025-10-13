<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallary extends Model
{
    public $table = 'gallaries';
    public $timestamps = true;

   protected $fillable = ['name','attachment','type_attachment'
                            ,'gp_name_in_url',
                            'gp_user_id'];

}
