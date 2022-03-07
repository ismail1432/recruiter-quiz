<?php

namespace App\Infrastructure\InMemory;

use App\Domain\Model\Question;
use App\Domain\Model\QuestionId;
use App\Domain\Repository\QuestionRepositoryInterface;

class InMemoryQuestionRepository implements QuestionRepositoryInterface
{
    private const QUESTIONS = [
        [
            'id' => 'b15a200c-8249-402f-a455-c4b4ef012236',
            'question' => 'Java is an abbreviation for Javascript?',
            'choices' => ['True', 'False'],
            'answer' => 1,
            'link' => 'https://en.wikipedia.org/wiki/Java_(programming_language)',
        ],
        [
            'id' => '909b4178-f5a9-44eb-926a-2a0a09870baf',
            'question' => 'Symfony is a framework written in Ruby?',
            'choices' => ['True', 'False'],
            'answer' => 1,
            'link' => 'https://youtu.be/iPXgoD52Mwc',
        ],
        [
            'id' => '2f87a26c-c22f-4869-befc-b75582787c74',
            'question' => 'The CSS is used for querying a database',
            'choices' => ['True', 'False'],
            'answer' => 1,
            'link' => 'https://en.wikipedia.org/wiki/CSS',
        ],
        [
            'id' => 'c768382d-169e-4ad0-848a-6af40233782f',
            'question' => 'Who is the intruder among this list?',
            'choices' => ['Laravel', 'Yii', 'Symfony', 'Spring'],
            'answer' => 3,
            'link' => 'https://spring.io/',
        ],
        [
            'id' => 'a220804c-05a4-4352-8459-e115721ae091',
            'question' => 'Which technology is used to versioning code',
            'choices' => ['Docker', 'Git', 'AWS'],
            'answer' => 1,
            'link' => 'https://git-scm.com/book/en/v2/Getting-Started-About-Version-Control',
        ],
        [
            'id' => 'effbc17d-0e2e-46f1-ba7b-ab0095b6d1b8',
            'question' => 'Which company maintain Angular?',
            'choices' => ['Facebook', 'Google', 'Apple', 'Amazon'],
            'answer' => 1,
            'link' => 'https://medium.com/the-startup-lab-blog/the-history-of-angular-3e36f7e828c7',
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
            'answer' => 0,
            'link' => 'https://restfulapi.net/',
        ],
        [
            'id' => 'c8f3e157-d39c-498f-962e-12307d4ff5fb',
            'question' => 'Do all developers like babyfoot?',
            'choices' => ['True', 'False'],
            'answer' => 1,
        ],
        [
            'id' => '9a851117-1f04-4dc2-bbd0-02601e723d82',
            'question' => 'What is React?',
            'choices' => [
                'A Javascript library',
                'The evolution of JQuery',
                'A Java framework',
                'A JQuery library',
            ],
            'answer' => 0,
            'link' => 'https://reactjs.org/',
        ],
        [
            'id' => 'e6aaf3b7-6c4b-482e-a53d-1ac8bc4c46ca',
            'question' => 'Can you code in PHP without internet connection?',
            'choices' => ['True', 'False'],
            'answer' => 0,
        ],
        [
            'id' => '3d343ab2-600d-4855-9c6c-92ec2197c3ec',
            'question' => 'Which language use the sign "$" to create a variable?',
            'choices' => ['Javascript', 'PHP', 'Java', 'Ruby', 'Cobol', 'C'],
            'answer' => 1,
        ],
        [
            'id' => '9a2076ec-ffa2-44c4-a909-b95549d1639c',
            'question' => 'What is DevOps?',
            'choices' => ['A set of practices', 'A specific job', 'A developer that release very often'],
            'answer' => 0,
            'link' => 'https://aws.amazon.com/fr/devops/what-is-devops/#:~:text=DevOps%20is%20the%20combination%20of,development%20and%20infrastructure%20management%20processes.',
        ],
        [
            'id' => 'aa2eca53-aea8-494f-92f2-c66b25611bb4',
            'question' => 'Wordpress is no code tool',
            'choices' => ['True', 'False'],
            'answer' => 0,
        ],
        [
            'id' => 'fc6a0dcc-9eae-4855-9cba-cdac15524cb4',
            'question' => 'Who is the intruder in the following items?',
            'choices' => ['Singleton', 'Observer', 'Api', 'Strategy', 'Factory'],
            'answer' => 2,
        ],
        [
            'id' => '7d31e6a8-ea4b-4067-89fe-bdd769c63a0a',
            'question' => 'Which PHP version does not exist?',
            'choices' => ['5.4', '6.0', '7.4', '8.0', 'all of these version exists'],
            'answer' => 1,
            'link' => 'https://ma.ttias.be/php6-missing-version-number/',
        ],
        [
            'id' => '179e0a69-b52b-45c8-93fb-7352ef39928d',
            'question' => 'Which statement is true?',
            'choices' => [
                'CSS is for rendering element and HTML is for adding style',
                'HTML is a dynamic language',
                'HTML is for rendering element and CSS is for adding style',
            ],
            'answer' => 2,
        ],
        [
            'id' => '94b7f199-b750-48ba-af92-5224a336979f',
            'question' => 'Who is the intruder?',
            'choices' => ['Python', 'Ruby', 'Java', 'PHP', 'Swift'],
            'answer' => 4,
        ],
    ];

    /**
     * @var array<array{id: string, question: string, choices: array<string>, answer: int, link?: string}>
     */
    private array $questions;

    public function __construct()
    {
        $this->questions = self::QUESTIONS;
    }

    /**
     * {@inheritDoc}
     */
    public function getById(QuestionId $questionId): Question
    {
        foreach ($this->questions as $question) {
            if ($questionId->toString() === $question['id']) {
                return Question::create($questionId, $question['question'], $question['choices'], $question['answer'], $question['link'] ?? null);
            }
        }
        throw new \RuntimeException(sprintf('Question %s was not found', $questionId));
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): array
    {
        $questions = [];

        foreach ($this->questions as $question) {
            if (array_key_exists($question['id'], $questions)) {
                throw new \InvalidArgumentException(sprintf('id %s already exits', $question['id']));
            }

            $questions[$question['id']] = Question::create(QuestionId::fromString($question['id']), $question['question'], $question['choices'], $question['answer'], $question['link'] ?? null);
        }

        return $questions;
    }

    public function getTotalQuestion(): int
    {
        return count($this->getAll());
    }

    /**
     * @param array<array{id: string, question: string, choices: array<string>, answer: int, link?: string}> $questions
     */
    public function withQuestions(array $questions): self
    {
        $this->questions = $questions;

        return $this;
    }
}
