<?php

namespace App\Application\ShortenUrl\UseCase;

use App\Application\ShortenUrl\Action\GetShortenUrlAction;
use App\Application\ShortenUrl\Domain\Entity\ShortenUrlClick;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlClickRepositoryInterface;
use App\Application\ShortenUrl\Domain\Request\ShortenUrlClickRequest;
use DateTimeImmutable;

final readonly class GetOriginalUrlByAliasUseCase
{
    public function __construct(
        private GetShortenUrlAction $getShortenUrlAction,
        private ShortenUrlClickRepositoryInterface $shortenUrlClickRepository,
    ) {
    }

    public function run(string $alias, ShortenUrlClickRequest $request): string
    {
        $shorten = $this->getShortenUrlAction->run($alias);
        $click = new ShortenUrlClick(
            id: null,
            shortenUrlId: $shorten->id,
            clickedAt: new DateTimeImmutable(),
            ipAddress: $request->ipAddress,
            userAgent: $request->userAgent,
        );

        $this->shortenUrlClickRepository->save($click);

        return $shorten->originalUrl->value;
    }
}
