<?php

namespace MohamadSaleh\Reviewable\DTO;

class ReviewData
{
    public function __construct(
        public string  $body,
        public int     $rating,
        public ?string $id = null,
        public ?string $user_id = null,
        public ?string $reviewable_id = null,
        public ?string $reviewable_type = null,
        public ?string $title = null,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new self(...$data);
    }
}