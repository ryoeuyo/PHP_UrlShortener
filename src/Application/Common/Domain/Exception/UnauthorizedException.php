<?php

namespace App\Application\Common\Domain\Exception;

use DomainException;

final class UnauthorizedException extends DomainException
{
    /**
     * @var string
     */
    protected $message = 'Unauthorized';
}
