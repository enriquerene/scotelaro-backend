<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'modality_id',
        'instructor_id',
        'name',
        'capacity',
        'schedule', // JSON
        'notes',
    ];

    protected $casts = [
        'schedule' => 'array',
    ];

    public function modality()
    {
        return $this->belongsTo(Modality::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }
}
