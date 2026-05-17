<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Trainee extends Model
{
    protected $fillable = [
        'registration_no',
        'name',
        'guardian_name',
        'gender',
        'date_of_birth',
        'age',
        'phone',
        'alternate_phone',
        'email',
        'address',
        'city',
        'preferred_program_id',
        'education_level',
        'occupation',
        'previous_skill_experience',
        'reason_for_joining',
        'status',
        'source',
        'notes',
        'photo',
        'id_proof',
        'joined_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'joined_at' => 'datetime',
            'completed_at' => 'datetime',
            'age' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Trainee $trainee): void {
            if (! $trainee->registration_no) {
                $trainee->registration_no = self::generateRegistrationNumber();
            }
        });
    }

    public function preferredProgram(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'preferred_program_id');
    }

    private static function generateRegistrationNumber(): string
    {
        return DB::transaction(function (): string {
            $year = now()->format('Y');
            $prefix = "SKALA-{$year}-";

            $lastNumber = self::query()
                ->where('registration_no', 'like', $prefix.'%')
                ->lockForUpdate()
                ->orderByDesc('id')
                ->value('registration_no');

            $nextSequence = 1;

            if ($lastNumber && preg_match('/(\d{4})$/', $lastNumber, $matches)) {
                $nextSequence = ((int) $matches[1]) + 1;
            }

            return $prefix.str_pad((string) $nextSequence, 4, '0', STR_PAD_LEFT);
        }, 3);
    }
}
