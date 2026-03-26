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
    // User.php Model mein add karein
    // public function activeOrders() {
    //     // Maan lete hain aapke paas Order model hai
    //     return $this->hasMany(Order::class, 'delivery_id')->whereIn('status', ['pending', 'picked_up']);
    // }

    // Distance calculate karne ka helper (Haversine formula)
    public function getDistanceFrom($storeLat, $storeLong) {
        if (!$this->latitude || !$this->longitude) return "N/A";
        
        $earthRadius = 6371; // km
        $dLat = deg2rad($this->latitude - $storeLat);
        $dLon = deg2rad($this->longitude - $storeLong);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($storeLat)) * cos(deg2rad($this->latitude)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return round($earthRadius * $c, 2) . " km";
    }

    public function sponseredVendors()
    {
        return $this->hasOne(VendorSponsorship::class, 'vendor_id');
    }

    public function deviceToken()
    {
        return $this->hasOne(DeviceToken::class);
    }

    
}
