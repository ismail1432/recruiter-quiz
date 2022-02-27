<?php

namespace App\Tests\SubmitAQuiz;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SubmitAQuizActionTest extends WebTestCase
{
    public function formAnswers(): iterable
    {
        yield '100%' => [
            [
                'quiz_form[111]' => 3, // Spring
                'quiz_form[222]'=>1, // Git
                'quiz_form[333]'=>1 // Google
            ],
            '100%'
        ];

        yield '66%' => [
            [
                'quiz_form[111]' => 3, // Spring
                'quiz_form[222]'=>1, // Git
                'quiz_form[333]'=>2 // Google
            ],
            '67%'
        ];

        yield '34%' => [
            [
                'quiz_form[111]' => 3, // Spring
                'quiz_form[222]'=>2, // Git
                'quiz_form[333]'=>2 // Google
            ],
            '33%'
        ];

        yield '0%' => [
            [
                'quiz_form[111]' => 2, // Spring
                'quiz_form[222]'=>2, // Git
                'quiz_form[333]'=>2 // Google
            ],
            '0%'
        ];
    }
    /**
     * @dataProvider formAnswers
     */
    public function testItSubmitWithSuccess(array $formAnswers, string $score): void
    {
        $client = $this->createClient();
            $crawler = $client->request('GET', '/')
        ;

        $form = $crawler->selectButton('Submit')->form();

        $form->setValues($formAnswers);

        $client->submit($form);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Check your result and the correction! ✅');
        $this->assertSelectorTextContains('h3', "You have {$score} of good answers");
    }

    public function testIt404()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/')
        ;

        $form = $crawler->selectButton('Submit')->form();
        $form->disableValidation();
        $form->setValues(['quiz_form[111]' => 'foo']);

        $client->submit($form);
        $this->assertResponseStatusCodeSame(404);

    }
}