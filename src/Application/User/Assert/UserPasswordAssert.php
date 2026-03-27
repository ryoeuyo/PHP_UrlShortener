<?php

namespace App\Application\User\Assert;

use App\Application\Common\Domain\Security\PasswordHasherInterface;
use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\Exception\InvalidCredentials;

final readonly class UserPasswordAssert
{
    public function __construct(
        private PasswordHasherInterface $hasher,
    ) {
    }

    public function run(User $user, string $plainPassword): void
    {
        if ($this->hasher->compare($plainPassword, $user->password) === false) {
            throw new InvalidCredentials();
        }
    }
}
