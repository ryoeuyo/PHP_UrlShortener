<?php

namespace App\Application\User\Domain\Response;

use App\Application\User\Domain\Entity\User;

final readonly class UserResponse
{
    public function __construct(
        public string $id,
        public string $email,
    ) {
    }

    public static function fromEntity(User $user): self
    {
        return new self(
            id: $user->id,
            email: $user->email,
        );
    }
}
