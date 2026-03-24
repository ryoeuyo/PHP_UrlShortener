<?php

namespace App\Application\User\UseCase;

use App\Application\User\Action\AssertUserPasswordAction;
use App\Application\User\Action\GenerateTokenFromUserAction;
use App\Application\User\Action\GetUserByEmailAction;
use App\Application\User\Domain\Request\LoginRequest;
use App\Application\User\Domain\Response\UserAuthenticatedResponse;

final readonly class LoginUserUseCase
{
    public function __construct(
        private GenerateTokenFromUserAction $generateTokenFromUserAction,
        private GetUserByEmailAction $getUserByEmailAction,
        private AssertUserPasswordAction $assertUserPasswordAction,
    ) {
    }

    public function run(LoginRequest $request): UserAuthenticatedResponse
    {
        $user = $this->getUserByEmailAction->run($request->email);
        $this->assertUserPasswordAction->run($user, $request->password);

        return new UserAuthenticatedResponse(
            $this->generateTokenFromUserAction->run($user),
        );
    }
}
