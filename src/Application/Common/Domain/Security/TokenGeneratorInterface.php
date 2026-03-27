<?php

namespace App\Application\Common\Domain\Security;

interface TokenGeneratorInterface
{
    /**
     * @param array<string, mixed> $payload
     */
    public function generate(array $payload): string;
}
