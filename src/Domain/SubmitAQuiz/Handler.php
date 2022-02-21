<?php

namespace App\Domain\SubmitAQuiz;

use App\Application\SubmitAQuiz\Input;
use App\Domain\Exception\InvalidSubmittedDataException;
use App\Domain\Model\Correction;
use App\Domain\Model\QuestionId;
use App\Domain\Model\Result;
use App\Domain\Model\Score;
use App\Domain\Model\SubmittedAnswer;
use App\Domain\Query\QueryInterface;
use App\Domain\Query\QueryHandlerInterface;
use App\Domain\Repository\QuestionRepositoryInterface;

final class Handler implements QueryHandlerInterface
{
    private QuestionRepositoryInterface $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(QueryInterface $input): Result
    {
        $totalAnswers = $this->questionRepository->getTotalQuestion();
        $result = [];
        $corrections = [];

        /** @var SubmittedAnswer $submittedAnswer */
        foreach ($this->buildSubmittedAnswers($input) as $submittedAnswer) {
            $question = $this->questionRepository->getById($submittedAnswer->getQuestionId());

            $corrections[] = $correction = Correction::create($question, $submittedAnswer);
            $result[] = $correction->isCorrect();
        }

        $goodAnswers = count(array_filter($result));

        return Result::create(
            $corrections,
            Score::create($this->toPercentage($goodAnswers, $totalAnswers))
        );
    }

    private function toPercentage(int $goodAnswers, int $totalAnswer): int
    {
        return (int) number_format(($goodAnswers / $totalAnswer) * 100);
    }

    /**
     * @return SubmittedAnswer[]
     */
    private function buildSubmittedAnswers(Input $input): array
    {
        $submittedAnswers = [];

        try {
            foreach ($input->getData() as $key => $value) {
                $submittedAnswers[] = SubmittedAnswer::create(QuestionId::fromString($key), $value);
            }
        } catch (\Throwable $e) {
            throw InvalidSubmittedDataException::invalidSubmittedData();
        }

        return $submittedAnswers;
    }
}
