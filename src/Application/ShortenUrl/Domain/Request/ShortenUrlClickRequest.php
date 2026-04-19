<?php

namespace App\Application\ShortenUrl\Domain\Request;

use App\Application\Common\Domain\ValueObject\Pagination;

final readonly class ShortenUrlClickRequest
{
    public function __construct(
        public string $ipAddress,
        public string $userAgent,
    ) {
    }
}
