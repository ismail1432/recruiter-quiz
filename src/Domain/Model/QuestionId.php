<?php

namespace App\Domain\Model;

final class QuestionId
{
    private string $value;

    public static function fromString(string $value): self
    {
        $self = new self();
        $self->value = $value;

        return $self;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
