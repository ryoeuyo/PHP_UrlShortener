<?php

namespace App\Application\Common\Domain\Security;

interface PasswordHasherInterface
{
    public function hash(string $password): string;
    public function compare(string $password, string $hashedPassword): bool;
}
