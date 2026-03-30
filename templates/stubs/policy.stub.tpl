<?php

declare(strict_types=1);

namespace App\Application\{{ entity }}\Domain\Policy;

use App\Application\Common\Domain\Exception\ForbiddenActionException;
use App\Application\Common\Domain\Enum\PolicyAction;
use App\Application\Common\Domain\Security\AuthorizationContext;

final readonly class {{ policy }}
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
