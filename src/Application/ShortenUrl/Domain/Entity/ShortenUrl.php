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
        public int $clicks,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $expiredAt,
    ) {
    }

    public function withIncrementedClicks(): self
    {
        return new self(
            id: $this->id,
            originalUrl: $this->originalUrl,
            alias: $this->alias,
            userId: $this->userId,
            clicks: $this->clicks + 1,
            createdAt: $this->createdAt,
            expiredAt: $this->expiredAt,
        );
    }
}
