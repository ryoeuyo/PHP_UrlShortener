<?php

namespace App\Infrastructure\Persistence\Mapper;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrl as DomainShortenUrl;
use App\Application\ShortenUrl\Domain\ValueObject\Url;
use App\Infrastructure\Persistence\Entity\ShortenUrl as DoctrineShortenUrl;
use App\Infrastructure\Persistence\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ShortenUrlMapper
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function toDomain(DoctrineShortenUrl $shortenUrl): DomainShortenUrl
    {
        return new DomainShortenUrl(
            id: $shortenUrl->getId(),
            originalUrl: Url::fromString($shortenUrl->getOriginalUrl()),
            alias: $shortenUrl->getAlias(),
            userId: $shortenUrl->getUser()->getId(),
            clicks: $shortenUrl->getClicks(),
            createdAt: $shortenUrl->getCreatedAt(),
            expiredAt: $shortenUrl->getExpiredAt(),
        );
    }

    public function toDoctrine(
        DomainShortenUrl $domain,
        DoctrineShortenUrl $doctrine = new DoctrineShortenUrl(),
    ): DoctrineShortenUrl {
        return $doctrine
            ->setId($domain->id)
            ->setOriginalUrl($domain->originalUrl->value)
            ->setAlias($domain->alias)
            ->setUser($this->entityManager->getReference(User::class, $domain->userId))
            ->setClicks($domain->clicks)
            ->setCreatedAt($domain->createdAt)
            ->setExpiredAt($domain->expiredAt);
    }
}
