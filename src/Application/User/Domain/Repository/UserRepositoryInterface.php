<?php

namespace App\Application\User\Domain\Repository;

use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\ValueObject\Email;

interface UserRepositoryInterface
{
    public function save(User $user): User;
    public function findByEmail(Email $email): ?User;
    public function findById(string $id): ?User;
}
