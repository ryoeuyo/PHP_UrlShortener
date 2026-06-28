<?php

namespace App\Application\ShortenUrl\UseCase;

use App\Application\Common\Domain\ValueObject\Pagination;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlClickRepositoryInterface;
use App\Application\ShortenUrl\Domain\Response\ShortenUrlClickFetchedListResponse;
use App\Application\User\Domain\Entity\User;

final readonly class GetShortenUrlClickListUseCase
{
    public function __construct(
        private ShortenUrlClickRepositoryInterface $repository,
    ) {
    }

    public function execute(User $user, int $shortenUrlId, Pagination $pagination): ShortenUrlClickFetchedListResponse
    {
        $clicks = $this->repository->findManyByShortenUrlIdAndUserId($shortenUrlId, $user->id, $pagination);
        $total = $this->repository->calcTotalByShortenUrlIdAndUserId($shortenUrlId, $user->id);

        return ShortenUrlClickFetchedListResponse::fromEntities($clicks, $total);
    }
}
