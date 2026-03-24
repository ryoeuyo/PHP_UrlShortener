<?php

namespace App\Application\User\Domain\Exception;

use DomainException;

final class InvalidCredentials extends DomainException
{
    /**
     * @var string
     */
    protected $message = "Invalid credentials";
}
