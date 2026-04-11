<?php

namespace Tests\Behat\Context\Database;

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Doctrine\DBAL\Connection;

final readonly class DatabaseContext implements Context
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    #[Given('пользователя с email :email не существует')]
    public function ensureUserDoesNotExist(string $email): void
    {
        $this->connection->executeStatement(
            'DELETE FROM users WHERE email = :email',
            ['email' => $email],
        );
    }
}
