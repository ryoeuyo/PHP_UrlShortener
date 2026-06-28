<?php

namespace App\Application\ShortenUrl\Domain\UrlProvider;

interface ShortenUrlProviderInterface
{
    public function provide(string $alias): string;
}
