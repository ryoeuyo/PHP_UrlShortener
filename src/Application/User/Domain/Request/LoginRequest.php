<?php

namespace App\Application\User\Domain\Request;

final readonly class LoginRequest
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
