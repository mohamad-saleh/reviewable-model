<?php

namespace MohamadSaleh\Reviewable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use MohamadSaleh\Reviewable\DTO\ReviewData;
use MohamadSaleh\Reviewable\Models\Review;

/**
 * @property \Illuminate\Database\Eloquent\Collection $reviews
 */
trait Reviewer
{
    public function addReview(Model $object, ReviewData|array $data): ?Review
    {
        $data = is_array($data) ? ReviewData::fromArray($data) : $data;
        /* @var \MohamadSaleh\Reviewable\Traits\Reviewable|Model $object */
        if (!$this->hasReviewer($object)) {
            $data->user_id = $this->getKey();
            $data->reviewable_id = $object->getKey();
            $data->reviewable_type = $object->getMorphClass();
            return $object->reviews()->create((array)$data);
        }

        return null;
    }

    public function updateReview(Model $object, ReviewData|array $data): bool
    {
        $data = is_array($data) ? ReviewData::fromArray($data) : $data;
        if ($review = $this->getFirstReviewer($object)) {
            return $review->update(Arr::only((array)$data, ['rating', 'title, body']));
        }
        return false;
    }

    public function updateOrCreateReview(Model $object, ReviewData|array $data): bool
    {
        if ($this->updateReview($object, $data)) {
            return (bool)$this->addReview($object, $data);
        }
        return true;
    }

    public function removeReview(Model $object): bool
    {
        return $object->reviewers()
            ->where('reviewable_id', $object->getKey())
            ->where('reviewable_type', $object->getMorphClass())
            ->where('user_id', $this->getKey())
            ->delete();
    }


    public function hasReviewer(Model $object): bool
    {
        return (bool)$this->getFirstReviewer($object);
    }

    public function getFirstReviewer(Model $object): ?Review
    {
        return ($this->relationLoaded('reviewers') ? $this->reviews : $this->reviewers())
            ->where('reviewable_id', $object->getKey())
            ->where('reviewable_type', $object->getMorphClass())
            ->first();
    }

    public function reviewers(): HasMany
    {
        return $this->hasMany(Review::class, config('review.user_foreign_key'), $this->getKeyName());
    }

    public function getReviewItems(string $model)
    {
        return app($model)->whereHas(
            'reviewers',
            function ($q) {
                return $q->where('user_id', $this->getKey());
            }
        );
    }
}
