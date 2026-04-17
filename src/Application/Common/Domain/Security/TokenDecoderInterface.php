<?php

namespace App\Application\Common\Domain\Security;

use App\Application\Common\Domain\Exception\UnauthorizedException;

interface TokenDecoderInterface
{
    /**
     * @return array<string, mixed>
     *
     * @throws UnauthorizedException
     */
    public function decode(string $token): array;
}
