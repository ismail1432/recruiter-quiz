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

    public function __invoke(QueryInterface $input): Output
    {
        $totalAnswers = count($input->getData());
        $result = [];
        $corrections = [];

        foreach ($input->getData() as $key => $value) {
            try {
                $submittedAnswer = SubmittedAnswer::create(QuestionId::fromString($key), $value);
                $question = $this->questionRepository->getById($submittedAnswer->getQuestionId());

                $corrections[] = $correction = Correction::create($question, $submittedAnswer);
                $result[] = $correction->isCorrect();
            } catch (\Throwable) {
                throw InvalidSubmittedDataException::invalidSubmittedData();
            }
        }

        $goodAnswers = count(array_filter($result));

        return Output::createFromResult(Result::create(
            $corrections,
            Score::create($this->toPercentage($goodAnswers, $totalAnswers))
        ));
    }

    private function toPercentage(int $goodAnswers, int $totalAnswer): int
    {
        return (int) number_format(($goodAnswers / $totalAnswer) * 100);
    }
}
