<?php

namespace App\Application\ShortenUrl\Domain\Repository;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrl as DomainShortenUrl;

interface ShortenUrlRepositoryInterface
{
    public function save(DomainShortenUrl $shortenUrl): DomainShortenUrl;

    public function findActiveByAlias(string $alias): ?DomainShortenUrl;
}
