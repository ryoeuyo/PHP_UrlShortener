<?php

namespace App\Infrastructure\Persistence\Repository;

use App\Application\User\Domain\Entity\User as DomainUser;
use App\Application\User\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Persistence\Entity\User as DoctrineUser;
use App\Infrastructure\Persistence\Mapper\UserMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<DoctrineUser>
 */
final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        ManagerRegistry $registry,
        private readonly UserMapper $mapper,
    ) {
        parent::__construct($registry, DoctrineUser::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(DomainUser $user): DomainUser
    {
        $entity = $this->findOneBy(['id' => Uuid::fromString($user->id)]);
        $isNew = !$entity;

        if ($isNew) {
            $entity = new DoctrineUser();
        }

        $entity = $this->mapper->toDoctrine($user, $entity);

        if ($isNew) {
            $this->entityManager->persist($entity);
        }

        $this->entityManager->flush();

        return $this->mapper->toDomain($entity);
    }

    public function findByEmail(string $email): ?DomainUser
    {
        $entity = $this->findOneBy(['email' => $email]);

        return $entity ? $this->mapper->toDomain($entity) : null;
    }

    public function findById(string $id): ?DomainUser
    {
        $entity = $this->findOneBy(['id' => Uuid::fromString($id)]);

        return $entity ? $this->mapper->toDomain($entity) : null;
    }
}
