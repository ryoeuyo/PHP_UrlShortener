<?php

namespace App\Application\User\Domain\Entity;

final readonly class User
{
    public function __construct(
        public ?string $id,
        public string $email,
        public string $password,
    ) {
    }
}
