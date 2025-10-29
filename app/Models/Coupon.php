<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_cart_amount',
        'starts_at',
        'expires_at',
        'usage_limit',
        'usage_count',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'float',
        'min_cart_amount' => 'float',
    ];

    /**
     * Check if the coupon is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        
        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->lt($now)) {
            return false;
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Calculate the discount amount for a given amount.
     *
     * @param float $amount
     * @return float
     */
    public function calculateDiscount(float $amount): float
    {
        if (!$this->isValid()) {
            return 0;
        }

        if ($this->min_cart_amount && $amount < $this->min_cart_amount) {
            return 0;
        }

        if ($this->type === 'fixed') {
            return min($this->value, $amount);
        }

        // percent
        return $amount * ($this->value / 100);
    }

    /**
     * Apply the coupon to a given amount.
     *
     * @param float $amount
     * @return float
     */
    public function applyTo(float $amount): float
    {
        $discount = $this->calculateDiscount($amount);
        return max(0, $amount - $discount);
    }

    /**
     * Increment the usage count.
     *
     * @return void
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Scope a query to only include active coupons.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $now = now();
        
        return $query->where('is_active', true)
            ->where('starts_at', '<=', $now)
            ->where(function($query) use ($now) {
                $query->where('expires_at', '>', $now)
                      ->orWhereNull('expires_at');
            })
            ->where(function($query) {
                $query->whereNull('usage_limit')
                      ->orWhereRaw('usage_count < usage_limit');
            });
    }
}
