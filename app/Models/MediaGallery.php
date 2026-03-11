<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaGallery extends Model
{
    use HasFactory;

    protected $table = 'media_gallery';

    protected $fillable = [
        'user_id',
        'image_path',
        'type',
    ];

    const TYPE_CART = 'cart';
    const TYPE_FOOD = 'food';
    const TYPE_MENU = 'menu';
    const TYPE_OTHER = 'other';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}