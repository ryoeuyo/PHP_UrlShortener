<?php

namespace App\Application\ShortenUrl\Domain\Response;

final readonly class UrlFetchedResponse
{
    public function __construct(
        public string $url,
        public string $expiredAt,
    ) {
    }
}
