<?php

namespace App\Infrastructure\Common\UrlProvider;

use App\Application\ShortenUrl\Domain\UrlProvider\ShortenUrlProviderInterface;

final readonly class ShortenUrlProvider implements ShortenUrlProviderInterface
{
    public function __construct(
        private string $defaultUrl,
    ) {
    }

    public function provide(string $alias): string
    {
        return $this->defaultUrl . '/r/' . $alias;
    }
}
