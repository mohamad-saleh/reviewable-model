<?php

namespace MohamadSaleh\Reviewable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use MohamadSaleh\Reviewable\Models\Review;
use MohamadSaleh\Reviewable\ValueObjects\Percent;

/**
 * @property \Illuminate\Database\Eloquent\Collection $reviewers
 * @property \Illuminate\Database\Eloquent\Collection $reviews
 */
trait Reviewable
{
    public function hasBeenReviewedBy(Model $user): bool
    {
        if (\is_a($user, config('auth.providers.users.model'))) {
            if ($this->relationLoaded('reviewers')) {
                return $this->reviewers->contains($user);
            }

            return ($this->relationLoaded('reviews') ? $this->reviews : $this->reviews())
                    ->where('user_id', $user->getKey())->exists();
        }

        return false;
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function reviewers(): BelongsToMany
    {
        return $this->belongsToMany(
            config('auth.providers.users.model'),
            'reviews',
            'reviewable_id',
            'user_id'
        )
            ->where('reviewable_type', $this->getMorphClass());
    }

    public function avgRating(): float
    {
        $reviews = ($this->relationLoaded('reviews') ? $this->reviews : $this->reviews())->get();

        return Percent::from($reviews->sum('rating'), $reviews->count())->value;
    }
}
