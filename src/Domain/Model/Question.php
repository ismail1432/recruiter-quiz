<?php

namespace App\Domain\Model;

final class Question
{
    private QuestionId $id;
    private string $question;
    /** @var array<string> */
    private array $choices;
    private int $answer;
    private ?string $link = null;

    private function __construct()
    {
    }

    /**
     * @param array<string> $choices
     */
    public static function create(QuestionId $id, string $question, array $choices, int $answer, ?string $link = null): self
    {
        $self = new self();
        $self->id = $id;
        $self->question = $question;
        $self->choices = $choices;
        $self->answer = $answer;
        $self->link = $link;

        return $self;
    }

    public function getAnswer(): int
    {
        return $this->answer;
    }

    public function getAnswerAsString(): string
    {
        return $this->choices[$this->answer];
    }

    /**
     * @return array<string>
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getId(): QuestionId
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }
}
