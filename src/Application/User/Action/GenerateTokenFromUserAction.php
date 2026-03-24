<?php

namespace App\Application\User\Action;

use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\Service\TokenGeneratorInterface;

final readonly class GenerateTokenFromUserAction
{
    public function __construct(
        private TokenGeneratorInterface $tokenGenerator,
    ) {
    }

    public function run(User $user): string
    {
        return $this->tokenGenerator->generate([
            'uid' => $user->uuid,
            'exp' => (new \DateTimeImmutable())->add(new \DateInterval('PT1H')),
        ]);
    }
}
