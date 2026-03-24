<?php

namespace App\Application\User\Domain\Service;

interface PasswordHasherInterface
{
    public function hash(string $password): string;
    public function compare(string $password, string $hashedPassword): bool;
}
