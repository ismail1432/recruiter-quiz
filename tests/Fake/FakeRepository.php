<?php

namespace App\Tests\Fake;

use App\Domain\Model\Question;
use App\Domain\Model\QuestionId;
use App\Domain\Repository\QuestionRepositoryInterface;
use App\Infrastructure\InMemory\InMemoryQuestionRepository;

class FakeRepository implements QuestionRepositoryInterface
{

    private QuestionRepositoryInterface $decorateQuestionRepository;

    public static $questions = [
        [
            'id' => '111',
            'question' => 'Who is the intruder among this list?',
            'choices' => ['Laravel', 'Yii', 'Symfony', 'Spring'],
            'answer' => 3,
        ],
        [
            'id' => '222',
            'question' => 'Which technology is used to versioning code',
            'choices' => ['Docker', 'Git', 'AWS'],
            'answer' => 1,
        ],
        [
            'id' => '333',
            'question' => 'Which company created Angular?',
            'choices' => ['Facebook', 'Google', 'Apple', 'Amazon'],
            'answer' => 1,
        ],
    ];

    public function __construct()
    {
        $this->decorateQuestionRepository = new InMemoryQuestionRepository(self::$questions);
    }

    public function getAll(): array
    {
        return $this->decorateQuestionRepository->getAll();
    }

    public function getById(QuestionId $questionId): Question
    {
        return $this->decorateQuestionRepository->getById($questionId);
    }

    public function getTotalQuestion(): int
    {
        return $this->decorateQuestionRepository->getTotalQuestion();
    }
}