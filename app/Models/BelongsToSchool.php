<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Menempelkan model ke sekolah admin yang sedang login.
 *
 * - Admin: query otomatis dibatasi ke school_id miliknya.
 * - Superadmin: bebas (tanpa scope) agar bisa mengelola semua sekolah.
 * - Tamu/console/queue: tanpa scope (dipakai landing publik, job, seeder).
 */
trait BelongsToSchool
{
    /**
     * Pengaman rekursi: auth()->user() sendiri me-query model User,
     * yang akan memicu scope ini lagi. Tanpa flag ini terjadi
     * infinite loop → memory habis → 500 kosong tanpa log.
     */
    protected static bool $resolvingSchoolScope = false;

    public static function bootBelongsToSchool(): void
    {
        static::addGlobalScope('school', function (Builder $query) {
            $schoolId = static::scopedSchoolId();

            if ($schoolId) {
                $query->where($query->getModel()->getTable().'.school_id', $schoolId);
            }
        });

        static::creating(function ($model) {
            if (empty($model->school_id) && ($schoolId = static::scopedSchoolId())) {
                $model->school_id = $schoolId;
            }
        });
    }

    protected static function scopedSchoolId(): ?int
    {
        if (static::$resolvingSchoolScope) {
            return null;
        }

        static::$resolvingSchoolScope = true;

        try {
            $user = auth()->user();

            if ($user && ! $user->isSuperAdmin() && $user->school_id) {
                return (int) $user->school_id;
            }

            return null;
        } finally {
            static::$resolvingSchoolScope = false;
        }
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
