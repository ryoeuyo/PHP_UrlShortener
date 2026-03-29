<?php

namespace App\Infrastructure\Security\Hashing;

use App\Application\Common\Domain\Security\PasswordHasherInterface;

final readonly class PasswordHasher implements PasswordHasherInterface
{

    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function compare(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}
