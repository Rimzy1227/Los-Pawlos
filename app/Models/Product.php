<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'image',
        'category'
    ];

    // --- Scopes (Encapsulated Query Logic) ---

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%")
                     ->orWhere('description', 'like', "%{$term}%");
    }

    public function scopeInCategory($query, $categoryName)
    {
        return $query->where('category', $categoryName);
    }

    // --- Accessors (Calculated Data) ---

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    // --- Mutators (Data Transformation) ---

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
