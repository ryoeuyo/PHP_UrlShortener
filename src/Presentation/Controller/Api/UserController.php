<?php

namespace App\Presentation\Controller\Api;

use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\Response\UserResponse;
use App\Infrastructure\Security\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/users', name: 'users')]
final class UserController extends AbstractController
{
    #[Route('/me', name: 'me', methods: ['GET'])]
    public function me(
        #[CurrentUser] User $user,
    ): JsonResponse {
        $response = UserResponse::fromEntity($user);

        return $this->json($response);
    }
}
