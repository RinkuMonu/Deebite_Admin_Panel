<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorSponsorship extends Model
{
    protected $fillable = [
        'vendor_id',
        'plan_id',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function plan()
    {
        return $this->belongsTo(SponsorshipPlan::class, 'plan_id');
    }
}