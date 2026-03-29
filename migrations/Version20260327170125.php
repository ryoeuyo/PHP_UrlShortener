<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260327170125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add expired_at field to shorten_urls table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shorten_urls ADD expired_at TIMESTAMPTZ DEFAULT NULL');
        $this->addSql('CREATE INDEX idx_shorten_urls_expired_at ON shorten_urls (expired_at)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IF EXISTS idx_shorten_urls_expired_at');
        $this->addSql('ALTER TABLE shorten_urls DROP COLUMN expired_at');
    }
}
