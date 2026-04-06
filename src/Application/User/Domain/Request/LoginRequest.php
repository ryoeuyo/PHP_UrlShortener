<?php

namespace App\Application\User\Domain\Request;

use App\Application\User\Domain\ValueObject\Email;

final readonly class LoginRequest
{
    public function __construct(
        public Email $email,
        public string $password,
    ) {
    }
}
