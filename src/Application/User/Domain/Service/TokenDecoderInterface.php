<?php

namespace App\Application\User\Domain\Service;

interface TokenDecoderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function decode(string $token): array;
}
