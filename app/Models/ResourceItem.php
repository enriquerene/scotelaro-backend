<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'category',
        'description',
        'quantity',
        'unit_cost',
        'total_cost',
        'purchase_date',
        'next_maintenance_date',
        'status',
        'responsible_user_id',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'next_maintenance_date' => 'date',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    // Category constants
    const CATEGORY_FIRST_AID = 'first_aid';
    const CATEGORY_MAINTENANCE = 'maintenance';
    const CATEGORY_MARKETING = 'marketing';
    const CATEGORY_EQUIPMENT = 'equipment';
    const CATEGORY_SUPPLIES = 'supplies';
    const CATEGORY_OTHER = 'other';

    public static function categories(): array
    {
        return [
            self::CATEGORY_FIRST_AID => 'First Aid Kit',
            self::CATEGORY_MAINTENANCE => 'Maintenance',
            self::CATEGORY_MARKETING => 'Marketing',
            self::CATEGORY_EQUIPMENT => 'Equipment',
            self::CATEGORY_SUPPLIES => 'Supplies',
            self::CATEGORY_OTHER => 'Other',
        ];
    }

    // Status constants
    const STATUS_AVAILABLE = 'available';
    const STATUS_IN_USE = 'in_use';
    const STATUS_MAINTENANCE = 'maintenance';
    const STATUS_DEPLETED = 'depleted';

    public static function statuses(): array
    {
        return [
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_IN_USE => 'In Use',
            self::STATUS_MAINTENANCE => 'Maintenance',
            self::STATUS_DEPLETED => 'Depleted',
        ];
    }

    // Calculate total cost if not set
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($resourceItem) {
            if ($resourceItem->quantity && $resourceItem->unit_cost && !$resourceItem->total_cost) {
                $resourceItem->total_cost = $resourceItem->quantity * $resourceItem->unit_cost;
            }
        });
    }
}
