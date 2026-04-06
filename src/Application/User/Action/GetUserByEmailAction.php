<?php

namespace App\Application\User\Action;

use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\Exception\UserNotFoundException;
use App\Application\User\Domain\Repository\UserRepositoryInterface;
use App\Application\User\Domain\ValueObject\Email;

final readonly class GetUserByEmailAction
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function run(Email $email): User
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
