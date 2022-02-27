<?php

namespace App\Domain\SubmitAQuiz;

use App\Domain\Model\Result;

final class Output
{
    private array $corrections;
    private int $score;

    private function __construct()
    {
    }

    public static function createFromResult(Result $result): self
    {
        $self = new self();

        $self->corrections = $result->getCorrections();
        $self->score = $result->getScore()->getValue();

        return $self;
    }

    public function getCorrections(): array
    {
        return $this->corrections;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
