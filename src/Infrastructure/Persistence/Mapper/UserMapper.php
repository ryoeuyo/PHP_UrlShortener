<?php

namespace App\Infrastructure\Persistence\Mapper;

use App\Application\User\Domain\Entity\User as DomainUser;
use App\Application\User\Domain\ValueObject\Email;
use App\Infrastructure\Persistence\Entity\User as DoctrineUser;
use Symfony\Component\Uid\Uuid;

final readonly class UserMapper
{
    public function toDomain(DoctrineUser $domain): DomainUser
    {
        return new DomainUser(
            id: $domain->getId()?->toString(),
            email: Email::fromString($domain->getEmail()),
            password: $domain->getPassword(),
        );
    }

    public function toDoctrine(DomainUser $domain, DoctrineUser $entity = new DoctrineUser()): DoctrineUser
    {
        $entity
            ->setId(Uuid::fromString($domain->id))
            ->setEmail($domain->email->value)
            ->setPassword($domain->password);

        return $entity;
    }
}
