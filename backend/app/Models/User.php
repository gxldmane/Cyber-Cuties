<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static Builder|User query()
 * @method static Builder|User cuties()
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return HasMany
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Follower::class, 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(Follower::class, 'following_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function media(): HasMany
    {
        return $this->hasMany(UserMedia::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'cutie_id');
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function ScopeCuties(Builder $query): Builder
    {
        return $query->where('role', 'cutie');
    }

}
