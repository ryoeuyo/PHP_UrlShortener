<?php

namespace App\Application\User\Domain\ValueObject;

use App\Application\Common\Domain\Exception\ValidationException;
use App\Application\Common\Domain\ValueObject\StringValueObjectInterface;

final readonly class Email implements StringValueObjectInterface
{
    private function __construct(public string $value)
    {
    }

    public static function fromString(string $value): self
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new ValidationException(['email' => 'The email is not valid']);
        }

        return new self($value);
    }
}
