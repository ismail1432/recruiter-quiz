<?php

namespace App\Domain\Repository;

use App\Domain\Model\Question;
use App\Domain\Model\QuestionId;

interface QuestionRepositoryInterface
{
    /**
     * @return \App\Domain\Model\Question[]
     */
    public function getAll(): array;

    public function getById(QuestionId $questionId): Question;

    public function getTotalQuestion(): int;
}
