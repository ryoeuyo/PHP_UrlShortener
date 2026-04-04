<?php

namespace App\Presentation\Controller\Api;

use App\Application\ShortenUrl\Domain\Request\CreateShortenUrlRequest;
use App\Application\ShortenUrl\UseCase\CreateShortenUrlUseCase;
use App\Application\User\Domain\Entity\User;
use App\Infrastructure\Security\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/shorten', name: 'shorten')]
final class ShortenController extends AbstractController
{
    #[Route(name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload] CreateShortenUrlRequest $request,
        CreateShortenUrlUseCase $uc,
        #[CurrentUser] User $user,
    ): JsonResponse {
        $response = $uc->run($request, $user);

        return $this->json($response, Response::HTTP_CREATED);
    }
}
