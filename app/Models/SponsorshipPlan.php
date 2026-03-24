<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsorshipPlan extends Model
{
    protected $fillable = [
        'plan_name',
        'description',
        'price',
        'duration_days',
        'placement',
        'priority',
        'status'
    ];

    public function vendorSponsorships()
    {
        return $this->hasMany(VendorSponsorship::class, 'plan_id');
    }
}