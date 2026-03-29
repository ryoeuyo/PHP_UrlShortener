<?php

namespace App\Infrastructure\Security\Uuid;

use App\Application\Common\Domain\Security\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

final readonly class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
