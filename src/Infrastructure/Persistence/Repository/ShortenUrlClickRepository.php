<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Application\Common\Domain\ValueObject\Pagination;
use App\Application\ShortenUrl\Domain\Entity\ShortenUrlClick as DomainShortenUrlClick;
use App\Application\ShortenUrl\Domain\Repository\ShortenUrlClickRepositoryInterface;
use App\Infrastructure\Persistence\Entity\ShortenUrlClick as DoctrineShortenUrlClick;
use App\Infrastructure\Persistence\Mapper\ShortenUrlClickMapper;
use App\Infrastructure\Persistence\Pagination\PaginationApplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineShortenUrlClick>
 */
final class ShortenUrlClickRepository extends ServiceEntityRepository implements ShortenUrlClickRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        ManagerRegistry $registry,
        private readonly ShortenUrlClickMapper $mapper,
        private readonly PaginationApplier $paginationApplier,
    ) {
        parent::__construct($registry, DoctrineShortenUrlClick::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(DomainShortenUrlClick $click): DomainShortenUrlClick
    {
        $entity = $this->findOneBy(['id' => $click->id]);
        $isNew = !$entity;

        if ($isNew) {
            $entity = new DoctrineShortenUrlClick();
        }

        $entity = $this->mapper->toDoctrine($click, $entity);

        if ($isNew) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();

        return $this->mapper->toDomain($entity);
    }

    /**
     * @return DomainShortenUrlClick[]
     */
    public function findManyByShortenUrlIdAndUserId(int $shortenUrlId, string $userId, Pagination $pagination): array
    {
        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.shortenUrl', 'u')
            ->where('c.shortenUrl = :shortenUrlId')
            ->andWhere('u.user = :userId')
            ->setParameter('shortenUrlId', $shortenUrlId)
            ->setParameter('userId', $userId);

        $clicks = $this->paginationApplier
            ->apply($qb, $pagination)
            ->getQuery()
            ->getResult();

        return array_map(
            fn (DoctrineShortenUrlClick $click): DomainShortenUrlClick => $this
                ->mapper
                ->toDomain($click),
            $clicks,
        );
    }

    public function calcTotalByShortenUrlIdAndUserId(int $shortenUrlId, string $userId): int
    {
        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.shortenUrl', 'u')
            ->where('c.shortenUrl = :shortenUrlId')
            ->andWhere('u.user = :userId')
            ->setParameter('shortenUrlId', $shortenUrlId)
            ->setParameter('userId', $userId);

        return (int) $qb->select('COUNT(DISTINCT c.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
