<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category; // Added Category import
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;

    // 1. CRITICAL: Added 'category_id' so it can actually be saved to the database
    protected $fillable = ['name', 'category_id', 'description', 'price', 'stock', 'image_url'];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Fix for Image Display:
     * If you use this accessor, you DO NOT need to add 'storage/' in your Blade file.
     * Simply use <img src="{{ $product->image_url }}">
     */
    public function getImageUrlAttribute($value)
    {
        if (!$value) {
            return asset('images/placeholder.png'); // Optional: Add a default image
        }
        return asset('storage/' . $value);
    }

    public function getPriceKesAttribute()
    {
        $exchangeRate = $this->getUsdToKesRate();
        return round($this->price * $exchangeRate, 2);
    }

    private function getUsdToKesRate()
    {
        try {
            $response = Http::get('https://api.exchangerate-api.com/v4/latest/USD');
            $data = $response->json();
            return $data['rates']['KES'] ?? config('app.usd_to_kes_fallback_rate', 120.00);
        } catch (\Exception $e) {
            Log::error('Error fetching USD to KES exchange rate: ' . $e->getMessage());
            return config('app.usd_to_kes_fallback_rate', 120.00);
        }
    }
}