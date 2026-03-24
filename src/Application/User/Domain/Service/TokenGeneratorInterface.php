<?php

namespace App\Application\User\Domain\Service;

interface TokenGeneratorInterface
{
    /**
     * @param array<string, mixed> $payload
     */
    public function generate(array $payload): string;
}
