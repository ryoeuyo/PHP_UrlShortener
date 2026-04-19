<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260419110048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove clicks field from shorten_urls, move clicks to separate table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            ALTER TABLE shorten_urls DROP COLUMN clicks;
        SQL);

        $this->addSql(<<<SQL
            CREATE TABLE shorten_url_clicks(
                id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
                shorten_url_id INT NOT NULL,
                clicked_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                ip_address VARCHAR(255) NOT NULL,
                user_agent VARCHAR(255) NOT NULL,
                CONSTRAINT fk_shorten_url_id
                FOREIGN KEY (shorten_url_id)
                REFERENCES shorten_urls (id)
                ON DELETE CASCADE
            );
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE shorten_url_clicks');
        $this->addSql('ALTER TABLE shorten_urls ADD clicks INT NOT NULL DEFAULT 0');
    }
}
