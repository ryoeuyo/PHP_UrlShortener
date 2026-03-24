<?php

namespace App\Application\Calculator\UseCase;

use App\Application\Calculator\Domain\Request\CalculateRequest;
use App\Application\Calculator\Domain\Response\CalculateResponse;

final readonly class CalculateUseCase
{
    public function run(CalculateRequest $request): CalculateResponse
    {
        $result = $request->left + $request->right;

        return new CalculateResponse($result);
    }
}
