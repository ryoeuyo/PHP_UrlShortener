<?php

namespace App\Application\ShortenUrl\Domain\Factory;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrl;
use App\Application\ShortenUrl\Domain\Response\UrlFetchedResponse;
use App\Application\ShortenUrl\Domain\UrlProvider\ShortenUrlProviderInterface;

final readonly class UrlFetchedResponseFactory
{
    public function __construct(
        private ShortenUrlProviderInterface $shortenUrlProvider,
    ) {
    }

    public function fromEntity(ShortenUrl $shortenUrl): UrlFetchedResponse
    {
        return new UrlFetchedResponse(
            url: $this->shortenUrlProvider->provide($shortenUrl->alias),
            expiredAt: $shortenUrl->expiredAt->format('Y-m-d H:i:s.u'),
        );
    }
}
