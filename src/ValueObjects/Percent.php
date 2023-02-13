<?php

namespace MohamadSaleh\Reviewable\ValueObjects;

class Percent
{
    public readonly float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public static function from(float $numerator, float $denominator)
    {
        if ($denominator === 0.0) {
            return new self(0);
        }

        return new self($numerator / $denominator);
    }
}
