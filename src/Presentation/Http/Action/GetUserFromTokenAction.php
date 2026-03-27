<?php

namespace App\Presentation\Http\Action;

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
            throw new UnauthorizedHttpException('Bearer', 'Missing bearer token');
        }

        $token = substr($header, 7);
        $payload = $this->tokenDecoder->decode($token);

        $uid = $payload['uid'] ?? null;
        if (!$uid) {
            throw new UnauthorizedHttpException('Bearer', 'Token does not contain uid');
        }

        $user = $this->userRepository->findById($uid);
        if (!$user) {
            throw new UnauthorizedHttpException('Bearer', 'User not found');
        }

        return $user;
    }
}
