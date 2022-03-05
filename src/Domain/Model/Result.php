<?php

namespace App\Domain\Model;

final class Result
{
    /** @var Correction[] */
    private $corrections;

    private Score $score;

    private function __construct()
    {
    }

    /** @param Correction[] $corrections */
    public static function create(array $corrections, Score $score): self
    {
        $self = new self();

        $self->corrections = $corrections;
        $self->score = $score;

        return $self;
    }

    /**
     * @return Correction[]
     */
    public function getCorrections(): array
    {
        return $this->corrections;
    }

    public function getScore(): Score
    {
        return $this->score;
    }
}
