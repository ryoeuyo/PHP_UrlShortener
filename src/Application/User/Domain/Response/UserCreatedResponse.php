<?php

namespace App\Application\User\Domain\Response;

use App\Application\User\Domain\Entity\User;

final readonly class UserCreatedResponse
{
    public function __construct(
        public string $uuid,
        public string $email,
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            uuid: $user->id,
            email: $user->email->value,
        );
    }
}
