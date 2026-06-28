<?php

namespace App\Application\ShortenUrl\Domain\Response;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrl;

final readonly class UrlFetchedResponse
{
    public function __construct(
        public string $url,
        public string $expiredAt,
    ) {
    }

    public static function fromEntity(ShortenUrl $shortenUrl, string $url): self
    {
        return new self(
            url: $url,
            expiredAt: $shortenUrl->expiredAt->format('Y-m-d H:i:s.u'),
        );
    }
}
