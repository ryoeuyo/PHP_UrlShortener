<?php

namespace App\Application\Common\Domain\Util;

interface RandomStringProviderInterface
{
    public function provide(int $length): string;
}
