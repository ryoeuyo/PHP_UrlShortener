<?php

declare(strict_types=1);

namespace App\Application\User\Domain\Policy;

use Application\Common\Domain\Exception\ForbiddenActionException;
use Application\EventManagement\Common\Domain\Enum\PolicyAction;
use Application\EventManagement\Common\Domain\Security\AuthorizationContext;

final readonly class UserPolicy
{
    public function assert(AuthorizationContext $ctx, PolicyAction $action): void
    {
        if ($this->can($ctx, $action) === false) {
            throw new ForbiddenActionException();
        }
    }

    private function can(AuthorizationContext $ctx, PolicyAction $action): bool
    {
        return match ($action) {
            PolicyAction::View => $this->canView($ctx),
            PolicyAction::Edit => $this->canEdit($ctx),
            PolicyAction::Delete => $this->canDelete($ctx),
            PolicyAction::Create => $this->canCreate($ctx),
        };
    }

    private function canView(AuthorizationContext $ctx): bool
    {
        return false;
    }

    private function canEdit(AuthorizationContext $ctx): bool
    {
        return false;
    }

    private function canDelete(AuthorizationContext $ctx): bool
    {
        return false;
    }

    private function canCreate(AuthorizationContext $ctx): bool
    {
        return false;
    }
}