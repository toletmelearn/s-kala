<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Certificate extends Model
{
    protected $fillable = [
        'certificate_no',
        'trainee_id',
        'training_program_id',
        'title',
        'issue_date',
        'completion_date',
        'verification_code',
        'status',
        'remarks',
        'issued_by',
        'qr_path',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'completion_date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Certificate $certificate): void {
            if (! $certificate->certificate_no) {
                $certificate->certificate_no = self::generateCertificateNumber();
            }

            if (! $certificate->verification_code) {
                $certificate->verification_code = self::generateVerificationCode();
            }
        });
    }

    public function trainee(): BelongsTo
    {
        return $this->belongsTo(Trainee::class);
    }

    public function trainingProgram(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class);
    }

    private static function generateCertificateNumber(): string
    {
        return DB::transaction(function (): string {
            $year = now()->format('Y');
            $prefix = "SKALA-CERT-{$year}-";

            $lastNumber = self::query()
                ->where('certificate_no', 'like', $prefix.'%')
                ->lockForUpdate()
                ->orderByDesc('id')
                ->value('certificate_no');

            $nextSequence = 1;

            if ($lastNumber && preg_match('/(\d{4})$/', $lastNumber, $matches)) {
                $nextSequence = ((int) $matches[1]) + 1;
            }

            return $prefix.str_pad((string) $nextSequence, 4, '0', STR_PAD_LEFT);
        }, 3);
    }

    private static function generateVerificationCode(): string
    {
        do {
            $code = 'SKALA-VERIFY-'.Str::upper(Str::random(8));
        } while (self::query()->where('verification_code', $code)->exists());

        return $code;
    }
}
