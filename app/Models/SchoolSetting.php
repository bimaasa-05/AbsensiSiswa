<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    protected $fillable = [
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

    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'school_name' => 'Sekolah',
                'check_in_time' => '07:00:00',
                'late_tolerance_minutes' => 15,
                'timezone' => 'Asia/Jakarta',
            ]
        );
    }
}
