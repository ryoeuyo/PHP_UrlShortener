<?php

namespace App\Application\Common\Domain\Exception;

use DomainException;
use Throwable;

abstract class NotFoundException extends DomainException
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        if ($message === '') {
            $message = sprintf('%s not found', $this->entity());
        }

        parent::__construct($message, $code, $previous);
    }

    abstract protected function entity(): string;
}
