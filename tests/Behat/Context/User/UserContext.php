<?php

namespace Tests\Behat\Context\User;

use App\Application\User\Domain\ValueObject\Email;
use App\Application\User\Domain\ValueObject\Password;
use App\Infrastructure\Persistence\Repository\UserRepository;
use Behat\Step\Given;
use Tests\Behat\Context\BaseContext;
use Tests\Behat\Factory\UserFactory;

final class UserContext extends BaseContext
{
    public function __construct(
        private readonly UserFactory $factory,
        private readonly UserRepository $repository,
    ) {
    }

    #[Given('существует пользователь с email :email и паролем :password')]
    public function createUser(string $email, string $password): void
    {
        $user = $this->repository->findByEmail(Email::fromString($email));
        if ($user !== null) {
            return;
        }

        $user = $this->factory->create($email, Password::fromString($password));
        $this->repository->save($user);
    }
}
