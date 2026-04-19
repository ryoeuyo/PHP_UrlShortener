<?php

namespace App\Application\ShortenUrl\Domain\Response;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrlClick;

final readonly class ShortenUrlClickListResponse
{
    /**
     * @param ShortenUrlClickResponse[] $items
     */
    public function __construct(
        public array $items,
        public int $total,
    ) {
    }

    /**
     * @param ShortenUrlClick[] $entities
     */
    public static function fromEntities(array $entities, int $total): self
    {
        return new self(
            items: array_map(
                fn (ShortenUrlClick $click): ShortenUrlClickResponse => ShortenUrlClickResponse::fromEntity($click),
                $entities,
            ),
            total: $total
        );
    }
}
