<?php

namespace App\Application\User\Action;

use App\Application\User\Domain\Exception\UserAlreadyExistsException;
use App\Application\User\Domain\Repository\UserRepositoryInterface;

final readonly class AssertUserNotExistsByEmailAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function run(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user) {
            throw new UserAlreadyExistsException();
        }
    }
}
