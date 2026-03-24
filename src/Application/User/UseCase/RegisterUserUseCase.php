<?php

namespace App\Application\User\UseCase;

use App\Application\Common\Domain\Service\UuidGeneratorInterface;
use App\Application\User\Action\AssertUserNotExistsByEmailAction;
use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\Repository\UserRepositoryInterface;
use App\Application\User\Domain\Request\RegisterRequest;
use App\Application\User\Domain\Response\UserCreatedResponse;
use App\Application\User\Domain\Service\PasswordHasherInterface;

final readonly class RegisterUserUseCase
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UuidGeneratorInterface $uuidGenerator,
        private PasswordHasherInterface $passwordHasher,
        private AssertUserNotExistsByEmailAction $assertUserNotExistsByEmailAction,
    ) {
    }

    public function run(RegisterRequest $request): UserCreatedResponse
    {
        $this->assertUserNotExistsByEmailAction->run($request->email);

        $user = new User(
            uuid: $this->uuidGenerator->generate(),
            email: $request->email,
            password: $this->passwordHasher->hash($request->password),
        );

        return UserCreatedResponse::fromEntity(
            $this->userRepository->save($user),
        );
    }
}
