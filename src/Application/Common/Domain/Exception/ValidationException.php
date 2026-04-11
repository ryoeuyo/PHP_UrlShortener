<?php

namespace App\Application\Common\Domain\Exception;

use DomainException;

final class ValidationException extends DomainException
{
    /**
     * @param string[] $violations
     */
    public function __construct(private readonly array $violations)
    {
        parent::__construct('Validation failed');
    }

    /**
     * @return string[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}
