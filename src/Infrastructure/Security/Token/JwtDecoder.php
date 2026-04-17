<?php

namespace App\Infrastructure\Security\Token;

use App\Application\Common\Domain\Exception\UnauthorizedException;
use App\Application\Common\Domain\Security\TokenDecoderInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;

final readonly class JwtDecoder implements TokenDecoderInterface
{
    private const ALG = 'HS256';

    public function __construct(
        private string $secret,
    ) {
    }

    public function decode(string $token): array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret, self::ALG));

            return (array) $decoded;
        } catch (Throwable) {
            throw new UnauthorizedException();
        }
    }
}
