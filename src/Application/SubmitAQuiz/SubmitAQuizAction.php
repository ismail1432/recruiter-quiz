<?php

namespace App\Application\SubmitAQuiz;

use App\Domain\Exception\InvalidSubmittedDataException;
use App\Domain\Model\Result;
use App\Domain\Model\Score;
use App\Domain\Query\QueryBusInterface;
use App\Domain\Query\QueryHandlerInterface;
use App\Domain\SubmitAQuiz\Handler;
use App\Domain\SubmitAQuiz\Output;
use App\Infrastructure\Symfony\Form\QuizForm;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class SubmitAQuizAction
{
    private QueryBusInterface $queryBus;
    private FormFactoryInterface $formFactory;
    private Environment $environment;

    public function __construct(QueryBusInterface $queryBus, FormFactoryInterface $formFactory, Environment $environment)
    {
        $this->queryBus = $queryBus;
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
                $output = $this->dispatch(new Input($form->getData()));

                return new Response($this->environment->render('quiz/result.html.twig', [
                    'corrections' => $output->getCorrections(),
                    'score' => $output->getScore()
                ]));
            } catch (InvalidSubmittedDataException) {
                throw new BadRequestHttpException();
            }
        }

        throw new NotFoundHttpException();
    }

    private function dispatch(Input $input): Output
    {
        return $this->queryBus->handle($input);
    }
}
