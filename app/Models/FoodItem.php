<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = ['vendor_id', 'category_id', 'name', 'image', 'description'];

    // Relationship: Vendor (User) se
    public function vendor() {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // Relationship: Category se
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Relationship: Variants se
    public function variants() {
        return $this->hasMany(FoodVariant::class);
    }
}