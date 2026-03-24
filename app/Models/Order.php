<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'delivery_partner_id',
        'address_id',
        'subtotal',
        'delivery_fee',
        'tax',
        'total',
        'status',
        'payment_status',
        'payment_method',
    ];

    // 🔹 Default attribute values (optional safety)
    protected $attributes = [
        'status' => 'pending',
        'payment_status' => 'pending',
        'payment_method' => 'COD',
        'subtotal' => 0,
        'delivery_fee' => 0,
        'tax' => 0,
        'total' => 0,
    ];

    // 🔹 Type Casting
    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Customer
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Delivery Partner (Rider)
    public function deliveryPartner()
    {
        return $this->belongsTo(DeliveryPartner::class);
    }

    // Address
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods (Optional but Useful)
    |--------------------------------------------------------------------------
    */

    // public function isPaid()
    // {
    //     return $this->payment_status === 'paid';
    // }

    // public function isDelivered()
    // {
    //     return $this->status === 'delivered';
    // }
}