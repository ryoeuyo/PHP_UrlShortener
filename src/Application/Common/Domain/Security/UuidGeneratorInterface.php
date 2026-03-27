<?php

namespace App\Application\Common\Domain\Security;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
