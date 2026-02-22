<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDakhala extends Model
{
    public $table = 'contact_dakhala';
    public $timestamps = true;

    protected $fillable = [
        'gp_name_in_url',
        'mobile_no',      
        'applicant_name',
        'print_name',
        'address',
        'certificate_type',
        'is_active',
        'is_deleted',
        'is_action_completed'
    ];
}
