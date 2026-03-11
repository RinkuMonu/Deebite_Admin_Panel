<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name',
        'profile_photo',
        'document_type',
        'document_file',
        'fssai_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}