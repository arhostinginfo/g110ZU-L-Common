<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['district_name', 'is_active', 'is_deleted'];

    public function talukas()
    {
        return $this->hasMany(Taluka::class);
    }
}
