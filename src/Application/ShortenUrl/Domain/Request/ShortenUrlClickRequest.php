<?php

namespace App\Application\ShortenUrl\Domain\Request;

final readonly class ShortenUrlClickRequest
{
    public function __construct(
        public string $ipAddress,
        public string $userAgent,
    ) {
    }
}
