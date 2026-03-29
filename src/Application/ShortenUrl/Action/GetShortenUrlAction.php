<?php

namespace App\Application\ShortenUrl\Action;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrl;
use App\Application\ShortenUrl\Domain\Exception\ShortenUrlNotFoundException;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlRepositoryInterface;

final readonly class GetShortenUrlAction
{
    public function __construct(
        private ShortenUrlRepositoryInterface $repository,
    ) {
    }

    public function run(string $alias): ShortenUrl
    {
        $shorten = $this->repository->findActiveByAlias($alias);

        if ($shorten === null) {
            throw new ShortenUrlNotFoundException();
        }

        return $shorten;
    }
}
