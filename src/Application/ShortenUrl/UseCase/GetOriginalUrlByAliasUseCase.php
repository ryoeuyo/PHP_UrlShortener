<?php

namespace App\Application\ShortenUrl\UseCase;

use App\Application\ShortenUrl\Action\GetShortenUrlAction;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlRepositoryInterface;

final readonly class GetOriginalUrlByAliasUseCase
{
    public function __construct(
        private GetShortenUrlAction $getShortenUrlAction,
    ) {
    }

    public function run(string $alias): string
    {
        $shorten = $this->getShortenUrlAction->run($alias);

        return $shorten->originalUrl->value;
    }
}
