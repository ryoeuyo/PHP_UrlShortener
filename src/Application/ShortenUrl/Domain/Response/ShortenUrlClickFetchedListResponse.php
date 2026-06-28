<?php

namespace App\Application\ShortenUrl\Domain\Response;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrlClick;

final readonly class ShortenUrlClickFetchedListResponse
{
    /**
     * @param ShortenUrlClickFetchedResponse[] $items
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
                fn (ShortenUrlClick $click): ShortenUrlClickFetchedResponse => ShortenUrlClickFetchedResponse::fromEntity($click),
                $entities,
            ),
            total: $total
        );
    }
}
