<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    protected $table = 'address_book';

    protected $fillable = [
        'user_id',
        'address_type',
        'address',
        'longitude',
        'latitude'
    ];

    protected $casts = [
        'longitude' => 'float',
        'latitude' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}