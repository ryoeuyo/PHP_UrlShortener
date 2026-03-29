<?php

namespace App\Application\ShortenUrl\UseCase;

use App\Application\ShortenUrl\Action\GenerateUniqueAliasAction;
use App\Application\ShortenUrl\Domain\Entity\ShortenUrl;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlRepositoryInterface;
use App\Application\ShortenUrl\Domain\Request\CreateShortenUrlRequest;
use App\Application\ShortenUrl\Domain\Response\ShortenUrlResponse;
use App\Application\User\Domain\Entity\User;
use DateInterval;
use DateTimeImmutable;
use Random\RandomException;

final readonly class CreateShortenUrlUseCase
{
    public function __construct(
        private ShortenUrlRepositoryInterface $shortenUrlRepository,
        private GenerateUniqueAliasAction $generateUniqueAliasAction,
    ) {
    }

    /**
     * @throws RandomException
     */
    public function run(CreateShortenUrlRequest $request, User $user): ShortenUrlResponse
    {
        $now = new DateTimeImmutable();

        $shortenUrl = new ShortenUrl(
            id: null,
            originalUrl: $request->url,
            alias: $this->generateUniqueAliasAction->run(),
            userId: $user->id,
            clicks: 0,
            createdAt: $now,
            expiredAt: $now->add(
                new DateInterval("PT{$request->ttlSeconds}S")
            ),
        );

        return ShortenUrlResponse::fromEntity(
            $this->shortenUrlRepository->save($shortenUrl),
        );
    }
}
