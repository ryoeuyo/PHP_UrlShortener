<?php

namespace App\Application\ShortenUrl\Domain\Entity;

use App\Application\ShortenUrl\Domain\ValueObject\Url;
use DateTimeImmutable;

final readonly class ShortenUrl
{
    public function __construct(
        public ?int $id,
        public Url $originalUrl,
        public string $alias,
        public string $userId,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $expiredAt,
    ) {
    }
}
