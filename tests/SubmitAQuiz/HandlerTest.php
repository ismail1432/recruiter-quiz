<?php

namespace App\Tests\SubmitAQuiz;

use App\Application\SubmitAQuiz\Input;
use App\Domain\Model\Question;
use App\Domain\Model\QuestionId;
use App\Domain\Model\SubmittedAnswer;
use App\Domain\Repository\QuestionRepositoryInterface;
use App\Domain\SubmitAQuiz\Handler;
use App\Infrastructure\InMemory\InMemoryQuestionRepository;
use PHPUnit\Framework\TestCase;

class HandlerTest extends TestCase
{

    public function calculProvider(): iterable
    {
        yield '0 %' => [
            new InMemoryQuestionRepository([
                ['id' => "1", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "2", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "3", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "4", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "5", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
            ]),
            [
                SubmittedAnswer::create(QuestionId::fromString('1'), 1),
                SubmittedAnswer::create(QuestionId::fromString('2'), 1),
                SubmittedAnswer::create(QuestionId::fromString('3'), 1),
                SubmittedAnswer::create(QuestionId::fromString('4'), 1),
                SubmittedAnswer::create(QuestionId::fromString('5'), 1),
            ],
            0
        ];

        yield '20 %' => [
            new InMemoryQuestionRepository([
                ['id' => "1", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "2", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "3", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "4", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "5", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
            ]),
            [
                SubmittedAnswer::create(QuestionId::fromString('1'), 1),
                SubmittedAnswer::create(QuestionId::fromString('2'), 1),
                SubmittedAnswer::create(QuestionId::fromString('3'), 1),
                SubmittedAnswer::create(QuestionId::fromString('4'), 1),
                SubmittedAnswer::create(QuestionId::fromString('5'), 1),
            ],
            20
        ];

        yield '25 %' => [
            new InMemoryQuestionRepository([
                ['id' => "1", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "2", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "3", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "4", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
            ]),
            [
                SubmittedAnswer::create(QuestionId::fromString('1'), 1),
                SubmittedAnswer::create(QuestionId::fromString('2'), 1),
                SubmittedAnswer::create(QuestionId::fromString('3'), 1),
                SubmittedAnswer::create(QuestionId::fromString('4'), 1),
            ],
            25
        ];

        yield '50 %' => [
            new InMemoryQuestionRepository([
                ['id' => "1", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "2", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "3", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
                ['id' => "4", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
            ]),
            [
                SubmittedAnswer::create(QuestionId::fromString('1'), 1),
                SubmittedAnswer::create(QuestionId::fromString('2'), 1),
                SubmittedAnswer::create(QuestionId::fromString('3'), 1),
                SubmittedAnswer::create(QuestionId::fromString('4'), 1),
            ],
            50
        ];

        yield '75 %' => [
            new InMemoryQuestionRepository([
                ['id' => "1", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 0],
                ['id' => "2", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
                ['id' => "3", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
                ['id' => "4", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
            ]),
            [
                SubmittedAnswer::create(QuestionId::fromString('1'), 1),
                SubmittedAnswer::create(QuestionId::fromString('2'), 1),
                SubmittedAnswer::create(QuestionId::fromString('3'), 1),
                SubmittedAnswer::create(QuestionId::fromString('4'), 1),
            ],
            75
        ];

        yield '100 %' => [
            new InMemoryQuestionRepository([
                ['id' => "1", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
                ['id' => "2", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
                ['id' => "3", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
                ['id' => "4", 'question' => 'foo', 'choices' => ['True', 'False'], 'answer' => 1],
            ]),
            [
                SubmittedAnswer::create(QuestionId::fromString('1'), 1),
                SubmittedAnswer::create(QuestionId::fromString('2'), 1),
                SubmittedAnswer::create(QuestionId::fromString('3'), 1),
                SubmittedAnswer::create(QuestionId::fromString('4'), 1),
            ],
            100
        ];

    }

    /**
     * @dataProvider calculProvider
     */
    public function testHandle(QuestionRepositoryInterface $questionRepository, array $submittedAnswers, int $expectedScore): void
    {
        $result = new Handler($questionRepository);

        $data = [];
        /** @var SubmittedAnswer $submittedAnswer */
        foreach ($submittedAnswers as $submittedAnswer) {
            $data[$submittedAnswer->getQuestionId()->toString()] = $submittedAnswer->getValue();
        }

        $score = $result->handle(new Input($data));

        self::assertEquals($expectedScore, $score->getScore()->getValue());
    }
}
