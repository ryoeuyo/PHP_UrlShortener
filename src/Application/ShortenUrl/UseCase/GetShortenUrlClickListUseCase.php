<?php

namespace App\Application\ShortenUrl\UseCase;

use App\Application\Common\Domain\ValueObject\Pagination;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlClickRepositoryInterface;
use App\Application\ShortenUrl\Domain\Response\ShortenUrlClickListResponse;
use App\Application\User\Domain\Entity\User;

final readonly class GetShortenUrlClickListUseCase
{
    public function __construct(
        private ShortenUrlClickRepositoryInterface $repository,
    ) {
    }

    public function execute(User $user, int $shortenUrlId, Pagination $pagination): ShortenUrlClickListResponse
    {
        $clicks = $this->repository->findManyByShortenUrlIdAndUserId($shortenUrlId, $user->id, $pagination);
        $total = $this->repository->calcTotalByShortenUrlIdAndUserId($shortenUrlId, $user->id);

        return ShortenUrlClickListResponse::fromEntities($clicks, $total);
    }
}
