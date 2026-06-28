<?php

namespace App\Application\ShortenUrl\Domain\Exception;

use App\Application\ShortenUrl\Assert\UserHasNotExceededLimitsAssert;
use DomainException;

/**
 * @see UserHasNotExceededLimitsAssert
 */
final class UserExceededLimitsException extends DomainException
{
    /** @var string */
    protected $message = 'User exceeded the maximum number of shorten urls allowed';
}
