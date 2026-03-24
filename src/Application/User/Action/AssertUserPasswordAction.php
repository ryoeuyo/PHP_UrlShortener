<?php

namespace App\Application\User\Action;

use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\Exception\InvalidCredentials;
use App\Application\User\Domain\Service\PasswordHasherInterface;

final readonly class AssertUserPasswordAction
{
    public function __construct(
        private PasswordHasherInterface $hasher,
    ) {
    }

    public function run(User $user, string $plainPassword): void
    {
        if ($this->hasher->compare($user->password, $plainPassword) === false) {
            throw new InvalidCredentials();
        }
    }
}
