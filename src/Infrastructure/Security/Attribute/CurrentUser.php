<?php

namespace App\Infrastructure\Security\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class CurrentUser
{
}
