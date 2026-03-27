<?php

namespace App\Application\Common\Domain\Security;

use App\Application\Common\Domain\Exception\UnauthorizedException;

interface TokenDecoderInterface
{
    /**
     * @throws UnauthorizedException
     * @return array<string, mixed>
     */
    public function decode(string $token): array;
}
