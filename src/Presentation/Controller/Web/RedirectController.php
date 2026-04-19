<?php

namespace App\Presentation\Controller\Web;

use App\Application\Common\Domain\ValueObject\Pagination;
use App\Application\ShortenUrl\Domain\Request\ShortenUrlClickRequest;
use App\Application\ShortenUrl\UseCase\GetOriginalUrlByAliasUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/r', name: 'redirect')]
final class RedirectController extends AbstractController
{
    #[Route('/{alias}', name: 'redirect', methods: ['GET'])]
    public function redirectByAlias(
        Request $request,
        string $alias,
        GetOriginalUrlByAliasUseCase $uc,
    ): RedirectResponse {
        $url = $uc->run(
            $alias,
            new ShortenUrlClickRequest(
                ipAddress: $request->getClientIp(),
                userAgent: $request->headers->get('User-Agent'),
            )
        );

        return $this->redirect($url);
    }
}
