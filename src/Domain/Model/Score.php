<?php

namespace App\Domain\Model;

final class Score
{
    private int $value;

    public function __construct()
    {
    }

    public static function create(int $value): self
    {
        $self = new self();
        $self->value = $value;

        return $self;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
