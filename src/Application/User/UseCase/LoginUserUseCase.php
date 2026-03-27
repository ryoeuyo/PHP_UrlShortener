<?php

namespace App\Application\User\UseCase;

use App\Application\User\Action\GenerateTokenFromUserAction;
use App\Application\User\Action\GetUserByEmailAction;
use App\Application\User\Assert\UserPasswordAssert;
use App\Application\User\Domain\Request\LoginRequest;
use App\Application\User\Domain\Response\UserAuthenticatedResponse;

final readonly class LoginUserUseCase
{
    public function __construct(
        private GenerateTokenFromUserAction $generateTokenFromUserAction,
        private GetUserByEmailAction $getUserByEmailAction,
        private UserPasswordAssert $userPasswordAssert,
    ) {
    }

    public function run(LoginRequest $request): UserAuthenticatedResponse
    {
        $user = $this->getUserByEmailAction->run($request->email);
        $this->userPasswordAssert->run($user, $request->password);

        return new UserAuthenticatedResponse(
            $this->generateTokenFromUserAction->run($user),
        );
    }
}
