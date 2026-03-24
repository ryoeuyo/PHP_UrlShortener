<?php

namespace App\Application\User\Domain\Exception;

use App\Application\Common\Domain\Exception\NotFoundException;

final class UserNotFoundException extends NotFoundException
{
    protected function entity(): string
    {
        return 'User';
    }
}
