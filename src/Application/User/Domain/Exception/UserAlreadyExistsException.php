<?php

namespace App\Application\User\Domain\Exception;

use DomainException;

final class UserAlreadyExistsException extends DomainException
{
    /**
     * @var string
     */
    protected $message = "User already exists";
}
