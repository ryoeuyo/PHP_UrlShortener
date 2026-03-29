<?php

namespace App\Application\ShortenUrl\Domain\Response;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrl;
use DateTimeImmutable;

final readonly class ShortenUrlResponse
{
    public function __construct(
        public string $alias,
        public string $originalUrl,
        public string $userId,
        public string $expiredAt,
    ) {
    }

    public static function fromEntity(ShortenUrl $shortenUrl): self
    {
        return new self(
            alias: $shortenUrl->alias,
            originalUrl: $shortenUrl->originalUrl->value,
            userId: $shortenUrl->userId,
            expiredAt: $shortenUrl->expiredAt->format("Y-m-d H:i:s.u"),
        );
    }
}
