<?php

namespace App\Application\ShortenUrl\Assert;

use App\Application\ShortenUrl\Domain\Exception\UserExceededLimitsException;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlRepositoryInterface;

final readonly class UserHasNotExceededLimitsAssert
{
    private const GLOBAL_LIMIT = 5;

    public function __construct(
        private ShortenUrlRepositoryInterface $shortenUrlRepository,
    ) {
    }

    public function assert(string $userId): void
    {
        $countTotal = $this->shortenUrlRepository->totalUrlsCountByUserId($userId);

        if ($countTotal >= self::GLOBAL_LIMIT) {
            throw new UserExceededLimitsException();
        }
    }
}
