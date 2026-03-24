<?php

namespace App\Application\User\Domain\Request;

final readonly class RegisterRequest
{
    public function __construct(
        public string $email,
        public string $password,
    ) {
    }
}
