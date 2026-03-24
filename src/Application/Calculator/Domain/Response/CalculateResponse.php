<?php

namespace App\Application\Calculator\Domain\Response;

final readonly class CalculateResponse
{
    public function __construct(
        public int $result,
    ) {
    }
}
