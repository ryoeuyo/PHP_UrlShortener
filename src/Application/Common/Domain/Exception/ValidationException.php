<?php

namespace App\Application\Common\Domain\Exception;

use DomainException;

final class ValidationException extends DomainException
{
    /**
     * @param array<string, string> $violations
     */
    public function __construct(private readonly array $violations)
    {
        parent::__construct('Validation failed');
    }

    public function getViolations(): array
    {
        return $this->violations;
    }
}
