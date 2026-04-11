<?php

namespace Tests\Behat\Factory;

use App\Application\Common\Domain\Security\PasswordHasherInterface;
use App\Application\Common\Domain\Security\UuidGeneratorInterface;
use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\ValueObject\Email;
use App\Application\User\Domain\ValueObject\Password;

final readonly class UserFactory
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private PasswordHasherInterface $passwordHasher,
    ) {
    }

    public function create(string $email, Password $password): User
    {
        return new User(
            id: $this->uuidGenerator->generate(),
            email: Email::fromString($email),
            password: $this->passwordHasher->hash($password),
        );
    }
}
