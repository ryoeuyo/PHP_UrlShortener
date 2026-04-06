<?php

namespace App\Application\User\Domain\Request;

use App\Application\User\Domain\ValueObject\Email;
use App\Application\User\Domain\ValueObject\Password;

final readonly class RegisterRequest
{
    public function __construct(
        public Email $email,
        public Password $password,
    ) {
    }
}
