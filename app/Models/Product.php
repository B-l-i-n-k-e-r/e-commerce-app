<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Http;

class Product extends Model
{
    use HasFactory;

    // Fillable attributes for mass assignment
    protected $fillable = ['name', 'description', 'price', 'stock', 'image_url'];

    protected $casts = [
        'price' => 'decimal:2', // Ensure price is treated as a decimal
    ];

    // Relationship: A product can belong to many orders
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product');
    }

    // Relationship: A product can have many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessor for the price in Kenyan Shillings
    public function getPriceKesAttribute()
    {
        $exchangeRate = $this->getUsdToKesRate();
        return round($this->price * $exchangeRate, 2);
    }

    // Private method to fetch the USD to KES exchange rate
    private function getUsdToKesRate()
    {
        // Replace with your actual API key and endpoint
        try {
            $response = Http::get('https://api.exchangerate-api.com/v4/latest/USD');
            $data = $response->json();
            return $data['rates']['KES'] ?? config('app.usd_to_kes_fallback_rate', 120.00);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error fetching USD to KES exchange rate: ' . $e->getMessage());
            return config('app.usd_to_kes_fallback_rate', 120.00);
        }
    }

    // Get the full URL of the product image from the 'image_url' attribute
    public function getImageUrlAttribute($value)
    {
        return asset('storage/' . $value);
    }
}