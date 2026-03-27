<?php

namespace App\Infrastructure\Security;

use App\Application\Common\Domain\Security\TokenGeneratorInterface;
use Firebase\JWT\JWT;

final readonly class JwtGenerator implements TokenGeneratorInterface
{
    private const ALG = 'HS256';

    public function __construct(
        private string $secret,
        private int $ttl,
    ) {
    }

    public function generate(array $payload): string
    {
        $now = time();

        $payload = array_merge($payload, [
            'iat' => $now,
            'exp' => $now + $this->ttl,
        ]);

        return JWT::encode($payload, $this->secret, self::ALG);
    }
}
