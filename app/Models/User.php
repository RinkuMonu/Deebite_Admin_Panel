<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
        'otp',
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
}
