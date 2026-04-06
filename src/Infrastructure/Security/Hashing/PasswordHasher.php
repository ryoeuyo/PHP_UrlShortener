<?php

namespace App\Infrastructure\Security\Hashing;

use App\Application\Common\Domain\Security\PasswordHasherInterface;
use App\Application\User\Domain\ValueObject\Password;

final readonly class PasswordHasher implements PasswordHasherInterface
{

    public function hash(Password $password): string
    {
        return password_hash($password->value, PASSWORD_BCRYPT);
    }

    public function compare(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
}
