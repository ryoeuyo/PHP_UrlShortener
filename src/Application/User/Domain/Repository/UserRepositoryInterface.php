<?php

namespace App\Application\User\Domain\Repository;

use App\Application\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): User;
    public function findByEmail(string $email): ?User;
    public function findById(string $id): ?User;
}
