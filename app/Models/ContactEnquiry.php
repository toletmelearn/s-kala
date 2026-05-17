<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContactEnquiry extends Model
{
    protected $fillable = [
        'enquiry_no',
        'type',
        'name',
        'organization',
        'phone',
        'email',
        'subject',
        'message',
        'preferred_contact_method',
        'status',
        'admin_notes',
        'contacted_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'contacted_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ContactEnquiry $enquiry): void {
            if (! $enquiry->enquiry_no) {
                $enquiry->enquiry_no = self::generateEnquiryNumber();
            }
        });
    }

    private static function generateEnquiryNumber(): string
    {
        return DB::transaction(function (): string {
            $year = now()->format('Y');
            $prefix = "SKALA-ENQ-{$year}-";

            $lastNumber = self::query()
                ->where('enquiry_no', 'like', $prefix.'%')
                ->lockForUpdate()
                ->orderByDesc('id')
                ->value('enquiry_no');

            $nextSequence = 1;

            if ($lastNumber && preg_match('/(\d{4})$/', $lastNumber, $matches)) {
                $nextSequence = ((int) $matches[1]) + 1;
            }

            return $prefix.str_pad((string) $nextSequence, 4, '0', STR_PAD_LEFT);
        }, 3);
    }
}
