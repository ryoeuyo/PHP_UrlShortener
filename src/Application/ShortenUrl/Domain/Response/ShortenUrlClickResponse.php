<?php

namespace App\Application\ShortenUrl\Domain\Response;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrlClick;

final readonly class ShortenUrlClickResponse
{
    public function __construct(
        public int $id,
        public string $clickedAt,
    ) {
    }

    public static function fromEntity(ShortenUrlClick $click): ShortenUrlClickResponse
    {
        return new self(
            id: $click->id,
            clickedAt: $click->clickedAt->format('Y-m-d H:i:s'),
        );
    }
}
