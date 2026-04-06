<?php

namespace App\Presentation\Controller\Web;

use App\Application\ShortenUrl\UseCase\GetOriginalUrlByAliasUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/r', name: 'redirect')]
final class RedirectController extends AbstractController
{
    #[Route('/{alias}', name: 'redirect', methods: ['GET'])]
    public function redirectByAlias(
        string $alias,
        GetOriginalUrlByAliasUseCase $uc,
    ): RedirectResponse {
        $url = $uc->run($alias);

        return $this->redirect($url);
    }
}
