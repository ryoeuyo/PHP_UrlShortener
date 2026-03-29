<?php

namespace App\Application\Common\Domain\ValueObject;

interface StringValueObjectInterface
{
    public static function fromString(string $value): self;
}
