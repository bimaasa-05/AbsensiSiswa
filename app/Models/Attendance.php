<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model
{
    public const STATUS_PRESENT = 'present';
    public const STATUS_LATE = 'late';
    public const STATUS_PERMISSION = 'permission';
    public const STATUS_SICK = 'sick';
    public const STATUS_ABSENT = 'absent';

    public const METHOD_QR = 'qr';
    public const METHOD_FINGERPRINT = 'fingerprint';
    public const METHOD_MANUAL = 'manual';

    protected $fillable = [
        'student_id',
        'attendance_date',
        'check_in',
        'check_out',
        'method',
        'status',
        'check_in_notification_status',
        'check_out_notification_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function corrections(): HasMany
    {
        return $this->hasMany(AttendanceCorrection::class);
    }

    public function hasCheckedIn(): bool
    {
        return $this->check_in !== null;
    }

    public function hasCheckedOut(): bool
    {
        return $this->check_out !== null;
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            self::STATUS_PRESENT => 'Hadir',
            self::STATUS_LATE => 'Terlambat',
            self::STATUS_PERMISSION => 'Izin',
            self::STATUS_SICK => 'Sakit',
            self::STATUS_ABSENT => 'Alpha',
            default => $status,
        };
    }
}
