<?php

namespace App\Infrastructure\Common\Library\Random;

use App\Application\Common\Domain\Util\RandomStringProviderInterface;
use Symfony\Component\String\ByteString;

final readonly class SymfonyRandomStringProvider implements RandomStringProviderInterface
{
    public function provide(int $length): string
    {
        return ByteString::fromRandom($length)->toString();
    }
}
