<?php

namespace App\Infrastructure\Security\Action;

use App\Application\Common\Domain\Security\TokenDecoderInterface;
use App\Application\User\Domain\Entity\User;
use App\Application\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final readonly class GetUserFromTokenAction
{
    public function __construct(
        private TokenDecoderInterface $tokenDecoder,
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function run(Request $request): User
    {
        $header = $request->headers->get('Authorization');
        if (!$header || !str_starts_with($header, 'Bearer ')) {
            $this->throwUnauthorizedHttpExceptionWithBearerChallenge('Missing bearer token');
        }

        $token = substr($header, 7);
        $payload = $this->tokenDecoder->decode($token);

        $uid = $payload['uid'] ?? null;
        if (!$uid) {
            $this->throwUnauthorizedHttpExceptionWithBearerChallenge('Token does not contain uid');
        }

        $user = $this->userRepository->findById($uid);
        if (!$user) {
            $this->throwUnauthorizedHttpExceptionWithBearerChallenge('User not found');
        }

        return $user;
    }

    private function throwUnauthorizedHttpExceptionWithBearerChallenge(string $message): never
    {
        throw new UnauthorizedHttpException(
            challenge: 'Bearer',
            message: $message,
            code: 401
        );
    }
}
