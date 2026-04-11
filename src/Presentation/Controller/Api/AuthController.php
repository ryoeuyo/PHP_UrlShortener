<?php

namespace App\Presentation\Controller\Api;

use App\Application\User\Domain\Request\LoginRequest;
use App\Application\User\Domain\Request\RegisterRequest;
use App\Application\User\UseCase\LoginUserUseCase;
use App\Application\User\UseCase\RegisterUserUseCase;
use App\Presentation\Common\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/auth', name: 'auth')]
final class AuthController extends BaseController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(
        LoginUserUseCase $uc,
        #[MapRequestPayload] LoginRequest $request,
    ): JsonResponse {
        $response = $uc->run($request);

        return $this->success($response);
    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        RegisterUserUseCase $uc,
        #[MapRequestPayload] RegisterRequest $request,
    ): JsonResponse {
        $response = $uc->run($request);

        return $this->success($response);
    }
}
