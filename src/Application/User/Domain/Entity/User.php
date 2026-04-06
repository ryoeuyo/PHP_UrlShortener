<?php

namespace App\Application\User\Domain\Entity;

use App\Application\User\Domain\ValueObject\Email;

final readonly class User
{
    public function __construct(
        public ?string $id,
        public Email $email,
        public string $password,
    ) {
    }
}
