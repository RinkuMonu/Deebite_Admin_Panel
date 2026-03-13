<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
    public function getProfilePhotoAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('default-avatar.png');
    }

    public function getDocumentFileAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}