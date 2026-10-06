<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardian extends Model
{
    use BelongsToSchool;

    protected $table = 'parents';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    protected $fillable = [
        'school_id',
        'name',
        'phone',
        'email',
        'status',
    ];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'parent_id');
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
