<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    use BelongsToSchool;

    protected $fillable = [
        'school_id',
        'school_name',
        'school_address',
        'school_phone',
        'check_in_time',
        'late_tolerance_minutes',
        'check_out_time',
        'timezone',
    ];

    protected function casts(): array
    {
        return [
            'late_tolerance_minutes' => 'integer',
        ];
    }

    public static function currentForSchool(?int $schoolId): self
    {
        return static::withoutGlobalScope('school')->firstOrCreate(
            ['school_id' => $schoolId],
            [
                'school_name' => $schoolId ? (School::find($schoolId)->name ?? 'Sekolah') : 'Sekolah',
                'check_in_time' => '07:00:00',
                'late_tolerance_minutes' => 15,
                'timezone' => 'Asia/Jakarta',
            ]
        );
    }

    public static function current(): self
    {
        return static::currentForSchool(auth()->user()?->school_id);
    }
}
