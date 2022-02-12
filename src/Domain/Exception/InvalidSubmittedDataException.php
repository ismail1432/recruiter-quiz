<?php

namespace App\Domain\Exception;

class InvalidSubmittedDataException extends \RuntimeException
{
    public static function invalidSubmittedData(): self
    {
        return new self('Unable to calculate the result because of invalid submitted data');
    }
}
