<?php

namespace Tests\Behat\Context;

use Behat\Behat\Context\Context;
use Tests\Behat\Exception\TestFailException;

abstract class BaseContext implements Context
{
    protected function fail(string $message): never
    {
        throw new TestFailException($message);
    }
}
