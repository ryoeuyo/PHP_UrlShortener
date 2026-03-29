<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260329141231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add clicks column to shorten_urls table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shorten_urls ADD clicks INT NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE shorten_urls DROP COLUMN clicks');
    }
}
