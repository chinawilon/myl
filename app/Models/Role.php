<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 */
class Role extends Model
{

    public const ADMIN_ID = 5; //管理员ID

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function isAdmin(): bool
    {
        return $this->id === self::ADMIN_ID;
    }
}
