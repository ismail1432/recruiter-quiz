<?php

namespace App\Application\SubmitAQuiz;

use App\Domain\Exception\InvalidSubmittedDataException;
use App\Domain\SubmitAQuiz\Handler;
use App\Infrastructure\Symfony\QuizForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class SubmitAQuizAction
{
    private Handler $handler;
    private FormFactoryInterface $formFactory;
    private Environment $environment;

    public function __construct(Handler $handler, FormFactoryInterface $formFactory, Environment $environment)
    {
        $this->handler = $handler;
        $this->formFactory = $formFactory;
        $this->environment = $environment;
    }

    #[Route('/', name: 'quiz', methods: ['post'])]
    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(QuizForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $result = $this->handler->handle(new Input($form->getData()));

                return new Response($this->environment->render('quiz/result.html.twig', [
                    'result' => $result,
                    'score' => $result->getScore()->getValue(),
                ]));
            } catch (InvalidSubmittedDataException) {
                throw new BadRequestHttpException();
            }
        }

        throw new NotFoundHttpException();
    }
}
