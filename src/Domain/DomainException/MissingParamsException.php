<?php

declare(strict_types=1);

namespace App\Domain\DomainException;

class MissingParamsException extends DomainException
{
    public $message = 'Required parameters are missing.';
}
