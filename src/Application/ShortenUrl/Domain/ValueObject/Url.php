<?php

namespace App\Application\ShortenUrl\Domain\ValueObject;

use App\Application\Common\Domain\ValueObject\StringValueObjectInterface;
use InvalidArgumentException;

final readonly class Url implements StringValueObjectInterface
{
    private function __construct(public string $value)
    {
    }

    public static function fromString(string $value): self
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException("Invalid URL");
        }

        return new self($value);
    }
}
