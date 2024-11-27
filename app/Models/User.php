<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Lumen\Auth\Authorizable;

/**
 * @property Carbon $expired_at
 * @property int $id
 * @property string $password
 * @property string $api_token
 * @property string $last_login_ip
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'expired_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function isTokenExpired(): bool
    {
        return Carbon::now()->gt($this->expired_at);
    }

    public function validToken(): bool
    {
        return !$this->isTokenExpired();
    }

    public function isAdmin(): bool
    {
        return $this->roles()->where('roles.id', Role::ADMIN_ID)->exists();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function latestPost(): HasOne
    {
        return $this->hasOne(Post::class)->latestOfMany();
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function saveLoginSuccess(string $token, string $ip): bool
    {
        $this->api_token = $token;
        $this->expired_at = \Illuminate\Support\Carbon::now()->addDays(10);
        $this->last_login_ip = $ip;
        return $this->save();
    }

    public function checkPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }
}
