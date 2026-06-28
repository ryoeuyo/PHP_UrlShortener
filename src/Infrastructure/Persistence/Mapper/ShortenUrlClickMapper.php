<?php

namespace App\Infrastructure\Persistence\Mapper;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrlClick as DomainShortenUrlClick;
use App\Infrastructure\Persistence\Entity\ShortenUrl;
use App\Infrastructure\Persistence\Entity\ShortenUrlClick as DoctrineShortenUrlClick;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ShortenUrlClickMapper
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function toDomain(DoctrineShortenUrlClick $domainEntity): DomainShortenUrlClick
    {
        return new DomainShortenUrlClick(
            id: $domainEntity->getId(),
            shortenUrlId: $domainEntity->getShortenUrl()->getId(),
            clickedAt: $domainEntity->getClickedAt(),
            ipAddress: $domainEntity->getIpAddress(),
            userAgent: $domainEntity->getUserAgent(),
        );
    }

    public function toDoctrine(
        DomainShortenUrlClick $domainEntity,
        DoctrineShortenUrlClick $doctrineEntity = new DoctrineShortenUrlClick(),
    ): DoctrineShortenUrlClick {
        return $doctrineEntity
            ->setId($domainEntity->id)
            ->setClickedAt($domainEntity->clickedAt)
            ->setShortenUrl(
                $this->entityManager->getReference(ShortenUrl::class, $domainEntity->shortenUrlId)
            )
            ->setIpAddress($domainEntity->ipAddress)
            ->setUserAgent($domainEntity->userAgent);
    }
}
