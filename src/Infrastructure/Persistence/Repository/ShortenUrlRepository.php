<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Application\ShortenUrl\Domain\Entity\ShortenUrl as DomainShortenUrl;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlRepositoryInterface;
use App\Infrastructure\Persistence\Entity\ShortenUrl as DoctrineShortenUrl;
use App\Infrastructure\Persistence\Mapper\ShortenUrlMapper;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineShortenUrl>
 */
final class ShortenUrlRepository extends ServiceEntityRepository implements ShortenUrlRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        ManagerRegistry $registry,
        private readonly ShortenUrlMapper $mapper,
    ) {
        parent::__construct($registry, DoctrineShortenUrl::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(DomainShortenUrl $shortenUrl): DomainShortenUrl
    {
        $entity = $this->findOneBy(['id' => $shortenUrl->id]);
        $isNew = !$entity;

        if ($isNew) {
            $entity = new DoctrineShortenUrl();
        }

        $entity = $this->mapper->toDoctrine($shortenUrl, $entity);

        if ($isNew) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();

        return $this->mapper->toDomain($entity);
    }

    public function findActiveByAlias(string $alias): ?DomainShortenUrl
    {
        $entity = $this->createQueryBuilder('su')
            ->where('su.alias = :alias')
            ->andWhere('su.expiredAt <= :now')
            ->setParameter('alias', $alias)
            ->setParameter('now', new DateTimeImmutable())
            ->getQuery()
            ->getOneOrNullResult();

        return $entity ? $this->mapper->toDomain($entity) : null;
    }
}
