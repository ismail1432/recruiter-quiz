<?php

namespace App\Domain\Model;

final class Correction
{
    private string $question;
    private ?string $submittedAnswer;
    private string $response;
    private bool $isCorrect;

    private function __construct()
    {
    }

    public static function create(Question $question, SubmittedAnswer $answer): self
    {
        $self = new self();

        $self->question = $question->getQuestion();
        $self->response = $question->getAnswerAsString();
        $self->submittedAnswer = $question->getChoices()[$answer->getValue()] ?? null;
        $self->isCorrect = $answer->isCorrect($question);

        return $self;
    }

    public function getSubmittedAnswer(): ?string
    {
        return $this->submittedAnswer;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function getResponse(): string
    {
        return $this->response;
    }
}
