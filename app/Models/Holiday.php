<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use BelongsToSchool;

    public const TYPE_NATIONAL = 'national';
    public const TYPE_SCHOOL = 'school';
    public const TYPE_WEEKEND = 'weekend';

    protected $fillable = [
        'school_id',
        'holiday_date',
        'name',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'holiday_date' => 'date',
        ];
    }

    public static function isHoliday(Carbon|string|null $date = null, ?int $schoolId = null): bool
    {
        $date = $date ? Carbon::parse($date)->toDateString() : today()->toDateString();

        return static::where('holiday_date', $date)
            ->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))
            ->exists();
    }

    public static function todayHoliday(?int $schoolId = null): ?self
    {
        return static::where('holiday_date', today()->toDateString())
            ->when($schoolId, fn ($q) => $q->where('school_id', $schoolId))
            ->first();
    }

    public static function typeLabel(string $type): string
    {
        return match ($type) {
            self::TYPE_NATIONAL => 'Nasional',
            self::TYPE_SCHOOL => 'Sekolah',
            self::TYPE_WEEKEND => 'Akhir Pekan',
            default => $type,
        };
    }
}
