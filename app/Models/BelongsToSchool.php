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
    public static function bootBelongsToSchool(): void
    {
        static::addGlobalScope('school', function (Builder $query) {
            $user = auth()->user();

            if ($user && ! $user->isSuperAdmin() && $user->school_id) {
                $query->where($query->getModel()->getTable().'.school_id', $user->school_id);
            }
        });

        static::creating(function ($model) {
            if (empty($model->school_id)) {
                $user = auth()->user();

                if ($user && ! $user->isSuperAdmin() && $user->school_id) {
                    $model->school_id = $user->school_id;
                }
            }
        });
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
