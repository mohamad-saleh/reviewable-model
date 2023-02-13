<?php

namespace  MohamadSaleh\Reviewable\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
/**
 * @property \Illuminate\Database\Eloquent\Model $user
 * @property \Illuminate\Database\Eloquent\Model $reviewer
 * @property \Illuminate\Database\Eloquent\Model $reviewable
 */
class Review extends Model
{
    use HasUuids;

    protected $table = 'reviews';

    protected $fillable = [
        'id',
        'user_id',
        'reviewable_id',
        'reviewable_type',
        'rating',
        'title',
        'body'
    ];

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\config('auth.providers.users.model'), 'user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->user();
    }

    public function scopeWithType(Builder $query, string $type): Builder
    {
        return $query->where('reviewable_type', app($type)->getMorphClass());
    }
}
