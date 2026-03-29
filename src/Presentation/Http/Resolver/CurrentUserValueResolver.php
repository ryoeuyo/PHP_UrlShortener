<?php

namespace App\Presentation\Http\Resolver;

use App\Application\User\Domain\Entity\User;
use App\Infrastructure\Security\Action\GetUserFromTokenAction;
use App\Infrastructure\Security\Attribute\CurrentUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class CurrentUserValueResolver implements ValueResolverInterface
{
    public function __construct(
        private GetUserFromTokenAction $getUserFromTokenAction,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $attributes = $argument->getAttributes(CurrentUser::class, ArgumentMetadata::IS_INSTANCEOF);

        if ($attributes === []) {
            return [];
        }

        if ($argument->getType() !== User::class) {
            return [];
        }

        yield $this->getUserFromTokenAction->run($request);
    }
}
