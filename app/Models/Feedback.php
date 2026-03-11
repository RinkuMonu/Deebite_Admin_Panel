<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['name', 'number', 'feedback'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}