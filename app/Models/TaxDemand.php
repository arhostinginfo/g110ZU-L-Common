<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxDemand extends Model
{
    public $table = 'tax_demands';
    public $timestamps = true;

    protected $fillable = [
        'gp_name_in_url',
        'tax_type',
        'year',
        'period',
        'demand_amount',
        'collected_amount',
        'percentage',
        'is_active',
    ];

    public function getPercentageAttribute()
    {
        if ($this->demand_amount > 0) {
            return round(($this->collected_amount / $this->demand_amount) * 100, 2);
        }
        return 0;
    }

    public function scopeForGp($query, $gpUrl)
    {
        return $query->where('gp_name_in_url', $gpUrl);
    }
}
