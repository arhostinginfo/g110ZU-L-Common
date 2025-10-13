<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taluka extends Model
{
    protected $fillable = ['taluka_name', 'district_id', 'is_active', 'is_deleted'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
