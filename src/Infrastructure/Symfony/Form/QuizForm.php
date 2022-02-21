<?php

namespace App\Infrastructure\Symfony\Form;

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

    private const EMOJIS = [
        '❓',
        '🍇',
        '🍄',
        '💡',
        '🧱',
        '🧵',
        '💿',
        '📒',
        '🖋️',
        '🧽',
        '💫',
        '🌕',
        '🔥',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $questions = $this->questionRepository->getAll();
        shuffle($questions);

        /** @var \App\Domain\Model\Question $question */
        foreach ($questions as $question) {
            $builder
                ->add($question->getId()->toString(), ChoiceType::class, [
                    'choices' => $this->buildChoiceElement($question),
                    'label' => $question->getQuestion(),
                ]);
        }

        $builder->add('Submit', SubmitType::class);
    }

    private function buildChoiceElement(Question $question): array
    {
        $choices = $this->shuffleChoices($question->getChoices());

        return array_merge([self::EMOJIS[array_rand(self::EMOJIS)] => 42], $choices);
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
