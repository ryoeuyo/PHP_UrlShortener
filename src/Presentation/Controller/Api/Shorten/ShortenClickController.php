<?php

namespace App\Presentation\Controller\Api\Shorten;

use App\Application\Common\Domain\ValueObject\Pagination;
use App\Application\ShortenUrl\UseCase\GetShortenUrlClickListUseCase;
use App\Application\User\Domain\Entity\User;
use App\Infrastructure\Security\Attribute\CurrentUser;
use App\Presentation\Common\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/shorten/{shortenId}/clicks', name: 'shorten_clicks', requirements: ['shortenId' => '.+'])]
final class ShortenClickController extends BaseController
{
    #[Route('/', methods: ['GET'])]
    public function list(
        Request $request,
        #[CurrentUser] User $user,
        GetShortenUrlClickListUseCase $uc,
        int $shortenId,
    ): JsonResponse {
        $response = $uc->execute(
            $user,
            $shortenId,
            new Pagination(
                page: $request->query->getInt('page', 1),
                limit: $request->query->getInt('limit', 10),
            )
        );

        return $this->success($response);
    }
}
