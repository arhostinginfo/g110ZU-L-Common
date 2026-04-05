<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxTip extends Model
{
    public $table = 'tax_tips';
    public $timestamps = true;

    protected $fillable = [
        'gp_name_in_url',
        'gp_user_id',
        'tip_text',
        'is_active',
        'is_deleted',
    ];
}
