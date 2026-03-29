<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260327164626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create shorten_urls table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
        CREATE TABLE shorten_urls (
            id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
            original_url VARCHAR(2048) NOT NULL,
            alias VARCHAR(64) NOT NULL,
            user_id UUID NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            CONSTRAINT fk_shorten_urls_user
                FOREIGN KEY (user_id)
                REFERENCES users (id)
                ON DELETE CASCADE
        )
    SQL);

        $this->addSql('CREATE UNIQUE INDEX uniq_shorten_urls_alias ON shorten_urls (alias)');
        $this->addSql('CREATE INDEX idx_shorten_urls_user_id ON shorten_urls (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<SQL
            DROP TABLE IF EXISTS shorten_urls;
        SQL);
    }
}
