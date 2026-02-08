<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modality extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'image',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function classes()
    {
        return $this->hasMany(GymClass::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modality) {
            if (empty($modality->slug)) {
                $modality->slug = \Illuminate\Support\Str::slug($modality->name);
            }
        });

        static::updating(function ($modality) {
            if ($modality->isDirty('name') && empty($modality->slug)) {
                $modality->slug = \Illuminate\Support\Str::slug($modality->name);
            }
        });
    }
}
