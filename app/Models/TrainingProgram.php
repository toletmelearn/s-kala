<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingProgram extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'category',
        'duration',
        'level',
        'outcome',
        'image',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(Trainer::class, 'training_program_trainer')
            ->withTimestamps();
    }

    public function trainees(): HasMany
    {
        return $this->hasMany(Trainee::class, 'preferred_program_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }
}
