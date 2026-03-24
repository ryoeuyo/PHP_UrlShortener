<?php

namespace App\Application\Calculator\Domain\Request;

final readonly class CalculateRequest
{
    public function __construct(
        public int $left,
        public int $right,
    ) {
    }
}
