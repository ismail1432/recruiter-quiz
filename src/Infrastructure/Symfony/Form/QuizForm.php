<?php

namespace App\Infrastructure\Symfony\Form;

use App\Domain\Emoji\Random;
use App\Domain\Model\Question;
use App\Domain\Repository\QuestionRepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class QuizForm extends AbstractType
{
    private QuestionRepositoryInterface $questionRepository;

    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $questions = $this->questionRepository->getAll();
        shuffle($questions);

        /** @var \App\Domain\Model\Question $question */
        foreach ($questions as $question) {
            $builder
                ->add($question->getId()->toString(), ChoiceType::class, [
                    'attr' => ['class' =>'select-css'],
                    'choices' => $this->buildChoiceElement($question),
                    'label' => $question->getQuestion(),
                ]);
        }

        $builder->add(
            'Submit',
            SubmitType::class,
            [
                'attr' => [
                    'class' =>'button-submit',
                    ],
            ]
        );
    }

    private function buildChoiceElement(Question $question): array
    {
        return array_merge(
            [Random::ALL[array_rand(Random::ALL)] => 42],
            $this->shuffleChoices(
                $question->getChoices()
            )
        );
    }

    private function shuffleChoices(array $choices): array
    {
        $keys = array_keys($choices);
        shuffle($keys);
        $random = [];
        foreach ($keys as $key) {
            $random[(int) $key] = $choices[$key];
        }

        return array_flip($random);
    }
}
