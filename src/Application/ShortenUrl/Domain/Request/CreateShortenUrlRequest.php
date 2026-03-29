<?php

namespace App\Application\ShortenUrl\Domain\Request;

use App\Application\ShortenUrl\Domain\ValueObject\Url;

final readonly class CreateShortenUrlRequest
{
    public function __construct(
        public Url $url,
        public int $ttlSeconds,
    ) {
    }
}
