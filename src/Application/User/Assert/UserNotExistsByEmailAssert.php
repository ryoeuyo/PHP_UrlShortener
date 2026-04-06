<?php

namespace App\Application\User\Assert;

use App\Application\User\Domain\Exception\UserAlreadyExistsException;
use App\Application\User\Domain\Repository\UserRepositoryInterface;
use App\Application\User\Domain\ValueObject\Email;

final readonly class UserNotExistsByEmailAssert
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function run(Email $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user) {
            throw new UserAlreadyExistsException();
        }
    }
}
