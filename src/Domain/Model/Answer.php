<?php

namespace App\Domain\Model;

final class Answer
{
    private Question $question;
    private int $answer;

    private function __construct()
    {
    }

    public static function create(Question $question, int $answer): self
    {
        $self = new self();

        $self->question = $question;
        $self->answer = $answer;

        return $self;
    }

    public function isCorrect(): bool
    {
        return $this->question->getAnswer() === $this->answer;
    }
}
