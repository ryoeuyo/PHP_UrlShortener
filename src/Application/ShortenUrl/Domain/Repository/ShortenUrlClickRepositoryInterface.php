<?php

namespace App\Application\ShortenUrl\Domain\Repository;

use App\Application\Common\Domain\ValueObject\Pagination;
use App\Application\ShortenUrl\Domain\Entity\ShortenUrlClick;

interface ShortenUrlClickRepositoryInterface
{
    public function save(ShortenUrlClick $click): ShortenUrlClick;

    /**
     * @return ShortenUrlClick[]
     */
    public function findManyByShortenUrlIdAndUserId(
        int $shortenUrlId,
        string $userId,
        Pagination $pagination,
    ): array;

    public function calcTotalByShortenUrlIdAndUserId(
        int $shortenUrlId,
        string $userId,
    ): int;
}
