<?php

namespace App\Application\GetAQuiz;

use App\Domain\Query\QueryHandlerInterface;
use App\Infrastructure\Symfony\Form\QuizForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class GetAQuizAction
{
    private FormFactoryInterface $formFactory;
    private Environment $environment;

    public function __construct(FormFactoryInterface $formFactory, Environment $environment, QueryHandlerInterface $queryBus)
    {
        $this->formFactory = $formFactory;
        $this->environment = $environment;
    }

    #[Route('/', name: 'get_quiz', methods: ['get'])]
    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(QuizForm::class);

        return new Response($this->environment->render('quiz/quiz_form.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
