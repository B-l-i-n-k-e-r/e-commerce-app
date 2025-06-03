<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // Status constants that match your database
    public const STATUS_PENDING = 'Pending';
    public const STATUS_COMPLETED = 'Completed';
    public const STATUS_CANCELLED = 'Cancelled';

    // Payment method constants
    public const PAYMENT_MPESA = 'M-Pesa';
    public const PAYMENT_PAYPAL = 'PayPal';
    public const PAYMENT_CREDIT_CARD = 'Credit Card';

    protected $fillable = [
        'user_id',
        'shipping_name',
        'shipping_address',
        'contact_number',
        'email',
        'total_amount',
        'status',
        'payment_method',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    protected $attributes = [
        'status' => self::STATUS_PENDING, // Default status
    ];

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public static function getPaymentMethods(): array
    {
        return [
            self::PAYMENT_MPESA => 'M-Pesa',
            self::PAYMENT_PAYPAL => 'PayPal',
            self::PAYMENT_CREDIT_CARD => 'Credit Card',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Customer',
            'email' => $this->email,
        ]);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Alias for items() - you can keep both or remove one
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper method to check status
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}