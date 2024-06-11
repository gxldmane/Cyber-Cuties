<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


}
