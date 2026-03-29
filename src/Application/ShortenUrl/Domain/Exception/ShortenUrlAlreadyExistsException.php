<?php

namespace App\Application\ShortenUrl\Domain\Exception;

use DomainException;

final class ShortenUrlAlreadyExistsException extends DomainException
{
    /**
     * @var string
     */
    protected $message = 'Shorten url already exists.';
}
