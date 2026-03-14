<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
        'otp',
        'otp_expires_at',
        'role',
        'address',
        'latitude',
        'longitude',
        'is_active',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }
    public function vendorDetail()
    {
        return $this->hasOne(VendorDetail::class);
    }
    public function mediaGallery()
    {
        return $this->hasMany(MediaGallery::class);
    }
    public function foodItems()
    {
        return $this->hasMany(FoodItem::class, 'vendor_id');
    }

    public function sponseredVendors()
    {
        return $this->hasOne(VendorSponsorship::class, 'vendor_id');
    }


    
}
