<?php

namespace App\Tests\GetAQuiz;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class GetAQuizActionTest extends WebTestCase
{
    public function testItShowAQuiz(): void
    {
        $this->createClient()
            ->request('GET', '/')
        ;

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Welcome to the Tech Recruiter Quiz');
        $this->assertSelectorTextContains('#quiz_form_Submit', 'Submit');
    }
}