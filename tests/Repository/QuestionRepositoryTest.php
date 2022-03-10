<?php

namespace App\Tests\Repository;

use App\Domain\Model\QuestionId;
use App\Domain\Model\SubmittedAnswer;
use App\Domain\Repository\QuestionRepositoryInterface;
use App\Infrastructure\InMemory\InMemoryQuestionRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class QuestionRepositoryTest extends KernelTestCase
{
    private QuestionRepositoryInterface $questionRepository;

    public function setUp(): void
    {
        $this->questionRepository = new InMemoryQuestionRepository();
    }

    public function testGetAllHaveGoodAnswers(): void
    {
        /** @var QuestionRepositoryInterface $repository */
        $questions = $this->questionRepository->getAll();
        $answers = $this->getExpectedAnswers();

        /** @var \App\Domain\Model\Question $question */
        foreach ($questions as $question) {
            foreach ($answers as $answer) {
                if ($answer['question'] === $question->getQuestion()) {
                    $submittedValue = array_search($answer['answer'], $answer['choices']);
                    if (!is_int($submittedValue)) {
                        throw new \RuntimeException(sprintf("Invalid value for question: '%s'", $question->getQuestion()));
                    }
                    $submitted = SubmittedAnswer::create(QuestionId::fromString('42'), $submittedValue);
                    self::assertTrue($submitted->isCorrect($question), sprintf("Invalid answer '%s' for question '%s'", $answer['answer'], $question->getQuestion()));
                    continue 2;
                }
            }
        }
    }

    private function getExpectedAnswers(): array
    {
        return [
            [
                'question' => 'Java is an abbreviation for Javascript?',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'question' => 'Symfony is a framework written in Ruby?',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'question' => 'The CSS is used for querying a database',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'question' => 'Who is the intruder among this list?',
                'choices' => ['Laravel', 'Yii', 'Symfony', 'Spring'],
                'answer' => 'Spring',
            ],
            [
                'question' => 'Which technology is used to versioning code',
                'choices' => ['Docker', 'Git', 'AWS'],
                'answer' => 'Git',
            ],
            [
                'question' => 'Which company created Angular?',
                'choices' => ['Facebook', 'Google', 'Apple', 'Amazon'],
                'answer' => 'Google',
            ],
            [
                'question' => 'What is REST?',
                'choices' => [
                    'A software architectural style created to guide web services',
                    'A security protocol between web services',
                    'A coding style',
                    'A design pattern',
                ],
                'answer' => 'A software architectural style created to guide web services',
            ],
            [
                'question' => 'Do all developers like babyfoot?',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'question' => 'What is React?',
                'choices' => [
                    'A javascript framework',
                    'The evolution of JQuery',
                    'A java framework',
                    'A JQuery library',
                ],
                'answer' => 'A javascript framework',
            ],
            [
                'question' => 'Can you code in PHP without internet connection?',
                'choices' => ['True', 'False'],
                'answer' => 'True',
            ],
            [
                'question' => 'Which language use the sign "$" to create a variable?',
                'choices' => ['Javascript', 'PHP', 'Java', 'Ruby', 'Cobol', 'C'],
                'answer' => 'PHP',
            ],
            [
                'question' => 'What is DevOps?',
                'choices' => ['A set of practices', 'A specific job', 'A developer that release very often'],
                'answer' => 'A set of practices',
            ],
            [
                'question' => 'Who is the intruder in the following items?',
                'choices' => ['Singleton', 'Observer', 'Api', 'Strategy', 'Factory'],
                'answer' => 'Api',
            ],
            [
                'question' => 'Which PHP version does not exist?',
                'choices' => ['5.4', '6.0', '7.4', '8.0', 'all of these version exists'],
                'answer' => '6.0',
            ],
            [
                'question' => 'Which statement is true?',
                'choices' => [
                    'CSS is for rendering element and HTML is for adding style',
                    'HTML is a dynamic language',
                    'HTML is for rendering element and CSS is for adding style',
                ],
                'answer' => 'HTML is for rendering element and CSS is for adding style',
            ],
            [
                'question' => 'Who is the intruder?',
                'choices' => ['Python', 'Ruby', 'Java', 'PHP', 'Swift'],
                'answer' => 'Swift',
            ],
            [
                'question' => 'Github is an open source platform for hosting source code.',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'question' => 'Who is the intruder?',
                'choices' => ['DRY', 'KISS', 'SCRUM', 'YAGNI'],
                'answer' => 'SCRUM',
            ],
        ];
    }
}
