<?php

namespace App\Application\SubmitAQuiz;

use App\Domain\Query\QueryInterface;

final class Input implements QueryInterface
{
    /**
     * @var array<string, int>
     */
    private array $data;

    /**
     * @param array<string, int> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array<string, int>
     */
    public function getData(): array
    {
        return $this->data;
    }
}
