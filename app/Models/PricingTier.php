<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingTier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'class_count',
        'price',
        'comparative_price',
        'billing_period',
        'frequency_type',
        'class_cap',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'comparative_price' => 'decimal:2',
        'is_active' => 'boolean',
        'class_count' => 'integer',
        'class_cap' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function modalities()
    {
        return $this->belongsToMany(Modality::class, 'pricing_tier_modality');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function hasActiveSubscriptions(): bool
    {
        return $this->subscriptions()->where('status', 'active')->exists();
    }
}
