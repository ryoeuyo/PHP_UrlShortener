<?php

namespace App\Application\Common\Domain\Security;

use App\Application\User\Domain\ValueObject\Password;

interface PasswordHasherInterface
{
    public function hash(Password $password): string;

    public function compare(string $password, string $hashedPassword): bool;
}
