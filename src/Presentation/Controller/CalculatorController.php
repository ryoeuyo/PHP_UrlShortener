<?php

namespace App\Presentation\Controller;

use App\Application\Calculator\Domain\Request\CalculateRequest;
use App\Application\Calculator\UseCase\CalculateUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/calculator')]
final class CalculatorController extends AbstractController
{
    #[Route('/calculate', name: 'calculator')]
    public function calculate(
        #[MapRequestPayload] CalculateRequest $request,
        CalculateUseCase $uc,
    ): JsonResponse {
        $response = $uc->run($request);

        return $this->json($response);
    }
}
