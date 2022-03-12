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
        $totalSubmitted = [];
        /** @var \App\Domain\Model\Question $question */
        foreach ($questions as $question) {
            foreach ($answers as $answer) {
                if ($answer['id'] === $question->getId()->toString()) {
                    $submittedValue = array_search($answer['answer'], $answer['choices']);
                    if (!is_int($submittedValue)) {
                        throw new \RuntimeException(sprintf("Invalid value for question: '%s'", $question->getQuestion()));
                    }
                    $submitted = SubmittedAnswer::create(QuestionId::fromString('42'), $submittedValue);
                    $totalSubmitted[] = $submitted;
                    self::assertTrue($submitted->isCorrect($question), sprintf("Invalid answer '%s' for question '%s'", $answer['answer'], $question->getQuestion()));
                    continue 2;
                }
            }
        }

        self::assertEquals(count($questions), count($totalSubmitted));
    }

    private function getExpectedAnswers(): array
    {
        return [
            [
                'id' => 'b15a200c-8249-402f-a455-c4b4ef012236',
                'question' => 'Java is an abbreviation for Javascript?',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'id' => '909b4178-f5a9-44eb-926a-2a0a09870baf',
                'question' => 'Symfony is a framework written in Ruby?',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'id' => '2f87a26c-c22f-4869-befc-b75582787c74',
                'question' => 'The CSS is used for querying a database',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'id' => 'c768382d-169e-4ad0-848a-6af40233782f',
                'question' => 'Who is the intruder among this list?',
                'choices' => ['Laravel', 'Yii', 'Symfony', 'Spring'],
                'answer' => 'Spring',
            ],
            [
                'id' => 'a220804c-05a4-4352-8459-e115721ae091',
                'question' => 'Which technology is used to versioning code',
                'choices' => ['Docker', 'Git', 'AWS'],
                'answer' => 'Git',
            ],
            [
                'id' => 'effbc17d-0e2e-46f1-ba7b-ab0095b6d1b8',
                'question' => 'Which company created Angular?',
                'choices' => ['Facebook', 'Google', 'Apple', 'Amazon'],
                'answer' => 'Google',
            ],
            [
                'id' => '8a4a6e82-8f4f-47e8-9a82-667faba01826',
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
                'id' => 'c8f3e157-d39c-498f-962e-12307d4ff5fb',
                'question' => 'Do all developers like babyfoot?',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'id' => '9a851117-1f04-4dc2-bbd0-02601e723d82',
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
                'id' => 'e6aaf3b7-6c4b-482e-a53d-1ac8bc4c46ca',
                'question' => 'Can you code in PHP without internet connection?',
                'choices' => ['True', 'False'],
                'answer' => 'True',
            ],
            [
                'id' => '3d343ab2-600d-4855-9c6c-92ec2197c3ec',
                'question' => 'Which language use the sign "$" to create a variable?',
                'choices' => ['Javascript', 'PHP', 'Java', 'Ruby', 'Cobol', 'C'],
                'answer' => 'PHP',
            ],
            [
                'id' => '9a2076ec-ffa2-44c4-a909-b95549d1639c',
                'question' => 'What is DevOps?',
                'choices' => ['A set of practices', 'A specific job', 'A developer that release very often'],
                'answer' => 'A set of practices',
            ],
            [
                'id' => 'fc6a0dcc-9eae-4855-9cba-cdac15524cb4',
                'question' => 'Who is the intruder in the following items?',
                'choices' => ['Singleton', 'Observer', 'Api', 'Strategy', 'Factory'],
                'answer' => 'Api',
            ],
            [
                'id' => '7d31e6a8-ea4b-4067-89fe-bdd769c63a0a',
                'question' => 'Which PHP version does not exist?',
                'choices' => ['5.4', '6.0', '7.4', '8.0', 'all of these version exists'],
                'answer' => '6.0',
            ],
            [
                'id' => '179e0a69-b52b-45c8-93fb-7352ef39928d',
                'question' => 'Which statement is true?',
                'choices' => [
                    'CSS is for rendering element and HTML is for adding style',
                    'HTML is a dynamic language',
                    'HTML is for rendering element and CSS is for adding style',
                ],
                'answer' => 'HTML is for rendering element and CSS is for adding style',
            ],
            [
                'id' => '94b7f199-b750-48ba-af92-5224a336979f',
                'question' => 'Guess who is the intruder?',
                'choices' => ['Python', 'Ruby', 'Java', 'PHP', 'Swift'],
                'answer' => 'Swift',
            ],
            [
                'id' => '43433d7c-1934-4294-bacd-b013aae65de7',
                'question' => 'Github is an open source platform for hosting source code.',
                'choices' => ['True', 'False'],
                'answer' => 'False',
            ],
            [
                'id' => 'e48a2892-a2fd-4a00-a80e-fe41721abdb8',
                'question' => 'Who is the intruder?',
                'choices' => ['DRY', 'KISS', 'SCRUM', 'YAGNI'],
                'answer' => 'SCRUM',
            ],
            [
                'id' => '74749c36-efb6-4276-b56a-319bb09ab8bf',
                'question' => 'What does QA stand for?',
                'choices' => ['Quality Assurance', 'Quick Assurance', 'Quality Acknowledge', 'Question & Answer'],
                'answer' => 'Quality Assurance',
            ],
        ];
    }
}
