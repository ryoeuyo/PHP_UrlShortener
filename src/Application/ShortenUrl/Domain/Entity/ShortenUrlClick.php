<?php

namespace App\Application\ShortenUrl\Domain\Entity;

use DateTimeImmutable;

final readonly class ShortenUrlClick
{
    public function __construct(
        public ?int $id,
        public int $shortenUrlId,
        public DateTimeImmutable $clickedAt,
        public string $ipAddress,
        public string $userAgent,
    ) {
    }
}
