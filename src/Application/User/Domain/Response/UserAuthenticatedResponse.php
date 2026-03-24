<?php

namespace App\Application\User\Domain\Response;

final readonly class UserAuthenticatedResponse
{
    public function __construct(
        public string $accessToken,
    ) {
    }
}
