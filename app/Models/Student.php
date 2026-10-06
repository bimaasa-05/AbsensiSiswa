<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Student extends Model
{
    use BelongsToSchool;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const GENDER_MALE = 'L';
    public const GENDER_FEMALE = 'P';

    protected $fillable = [
        'school_id',
        'nis',
        'nisn',
        'name',
        'class_id',
        'parent_id',
        'gender',
        'status',
        'qr_token',
        'fingerprint_identifier',
    ];

    protected static function booted(): void
    {
        static::creating(function (Student $student) {
            if (empty($student->qr_token)) {
                $student->qr_token = static::generateQrToken();
            }
        });
    }

    public static function generateQrToken(): string
    {
        do {
            $token = Str::random(48);
        } while (static::where('qr_token', $token)->exists());

        return $token;
    }

    public function regenerateQrToken(): void
    {
        $this->update(['qr_token' => static::generateQrToken()]);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function guardian(): BelongsTo
    {
        return $this->belongsTo(Guardian::class, 'parent_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
