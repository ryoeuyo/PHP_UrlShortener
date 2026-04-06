<?php

namespace App\Application\User\Domain\ValueObject;

use App\Application\Common\Domain\Exception\ValidationException;
use App\Application\Common\Domain\ValueObject\StringValueObjectInterface;

final readonly class Password implements StringValueObjectInterface
{
    private const REGEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    private function __construct(
        public string $value,
    ) {
    }

    public static function fromString(string $value): StringValueObjectInterface
    {
        if (!preg_match(self::REGEX, $value)) {
            throw new ValidationException(['password' => 'The password is weak']);
        }

        return new self($value);
    }

}
