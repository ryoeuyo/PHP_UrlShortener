<?php

namespace App\Application\Common\Domain\Service;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
