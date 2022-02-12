<?php

namespace App\Domain\Model;

class SubmittedAnswer
{
    private QuestionId $questionId;
    private int $value;

    public static function create(QuestionId $questionId, int $value): self
    {
        $self = new self();
        $self->questionId = $questionId;
        $self->value = $value;

        return $self;
    }

    public function getQuestionId(): QuestionId
    {
        return $this->questionId;
    }

    public function isCorrect(Question $question): bool
    {
        return $this->value === $question->getAnswer();
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
