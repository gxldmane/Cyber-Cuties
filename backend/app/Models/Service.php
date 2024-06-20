<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Service extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'cutie_id',
        'category_id',
        'description',
        'image_path'
    ];

    /**
     * @return BelongsTo
     */
    public function cutie(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cutie_id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function types(): HasMany
    {
        return $this->hasMany(ServiceType::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ScopeAlreadyReviewedBy($query, User $user): bool
    {
        return $query->whereHas('reviews', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->exists();
    }

}
