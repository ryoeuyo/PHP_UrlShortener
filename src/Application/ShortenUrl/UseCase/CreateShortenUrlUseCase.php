<?php

namespace App\Application\ShortenUrl\UseCase;

use App\Application\ShortenUrl\Action\GenerateUniqueAliasAction;
use App\Application\ShortenUrl\Assert\UserHasNotExceededLimitsAssert;
use App\Application\ShortenUrl\Domain\Entity\ShortenUrl;
use App\Application\ShortenUrl\Domain\Factory\UrlFetchedResponseFactory;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlRepositoryInterface;
use App\Application\ShortenUrl\Domain\Request\CreateShortenUrlRequest;
use App\Application\ShortenUrl\Domain\Response\UrlFetchedResponse;
use App\Application\User\Domain\Entity\User;
use DateInterval;
use DateTimeImmutable;

final readonly class CreateShortenUrlUseCase
{
    public function __construct(
        private ShortenUrlRepositoryInterface $shortenUrlRepository,
        private UserHasNotExceededLimitsAssert $userHasNotExceededLimitsAssert,
        private GenerateUniqueAliasAction $generateUniqueAliasAction,
        private UrlFetchedResponseFactory $urlFetchedResponseFactory,
    ) {
    }

    public function run(CreateShortenUrlRequest $request, User $user): UrlFetchedResponse
    {
        $this->userHasNotExceededLimitsAssert->assert($user->id);

        $now = new DateTimeImmutable();
        $shortenUrl = new ShortenUrl(
            id: null,
            originalUrl: $request->url,
            alias: $this->generateUniqueAliasAction->run(),
            userId: $user->id,
            createdAt: $now,
            expiredAt: $now->add(
                new DateInterval("PT{$request->ttlSeconds}S")
            ),
        );

        $saved = $this->shortenUrlRepository->save($shortenUrl);

        return $this->urlFetchedResponseFactory->fromEntity($saved);
    }
}
