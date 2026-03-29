<?php

namespace App\Application\ShortenUrl\Assert;

use App\Application\ShortenUrl\Domain\Exception\ShortenUrlAlreadyExistsException;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlRepositoryInterface;

final readonly class ShortenUrlNotExistsByAliasAssert
{
    public function __construct(
        private ShortenUrlRepositoryInterface $shortenUrlRepository,
    ) {
    }

    public function assert(string $alias): void
    {
        $shortenUrl = $this->shortenUrlRepository->findActiveByAlias($alias);

        if ($shortenUrl) {
            throw new ShortenUrlAlreadyExistsException();
        }
    }
}
