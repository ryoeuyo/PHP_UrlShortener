<?php

namespace App\Application\User\Action;

use App\Application\Common\Domain\Security\TokenGeneratorInterface;
use App\Application\User\Domain\Entity\User;

final readonly class GenerateTokenFromUserAction
{
    public function __construct(
        private TokenGeneratorInterface $tokenGenerator,
    ) {
    }

    public function run(User $user): string
    {
        return $this->tokenGenerator->generate([
            'uid' => $user->id,
        ]);
    }
}
