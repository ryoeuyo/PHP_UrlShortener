<?php

namespace App\Application\ShortenUrl\Domain\Exception;

use App\Application\Common\Domain\Exception\NotFoundException;

final class ShortenUrlNotFoundException extends NotFoundException
{
    protected function entity(): string
    {
        return 'Shorten Url';
    }
}
