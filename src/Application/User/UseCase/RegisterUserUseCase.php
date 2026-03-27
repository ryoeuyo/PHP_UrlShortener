<?php

namespace App\Application\User\UseCase;

use App\Application\Common\Domain\Security\PasswordHasherInterface;
use App\Application\Common\Domain\Security\UuidGeneratorInterface;
use App\Application\User\Assert\UserNotExistsByEmailAssert;
use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\Repository\UserRepositoryInterface;
use App\Application\User\Domain\Request\RegisterRequest;
use App\Application\User\Domain\Response\UserCreatedResponse;

final readonly class RegisterUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UuidGeneratorInterface $uuidGenerator,
        private PasswordHasherInterface $passwordHasher,
        private UserNotExistsByEmailAssert $assertUserNotExistsByEmailAction,
    ) {
    }

    public function run(RegisterRequest $request): UserCreatedResponse
    {
        $this->assertUserNotExistsByEmailAction->run($request->email);

        $user = new User(
            id: $this->uuidGenerator->generate(),
            email: $request->email,
            password: $this->passwordHasher->hash($request->password),
        );

        return UserCreatedResponse::fromEntity(
            $this->userRepository->save($user),
        );
    }
}
