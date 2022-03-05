<?php

namespace App\Domain\SubmitAQuiz;

use App\Domain\Model\Correction;
use App\Domain\Model\Result;

final class Output
{
    /**
     * @var Correction[]
     */
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

    /**
     * @return Correction[]
     */
    public function getCorrections(): array
    {
        return $this->corrections;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
