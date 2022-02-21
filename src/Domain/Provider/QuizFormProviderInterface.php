<?php

namespace App\Domain\Provider;

interface QuizFormProviderInterface
{
    public function create();

    public function submit();
}