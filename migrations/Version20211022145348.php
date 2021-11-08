<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022145348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stand ADD type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stand ADD CONSTRAINT FK_64B918B6C54C8C93 FOREIGN KEY (type_id) REFERENCES dictionnaire (id)');
        $this->addSql('CREATE INDEX IDX_64B918B6C54C8C93 ON stand (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stand DROP FOREIGN KEY FK_64B918B6C54C8C93');
        $this->addSql('DROP INDEX IDX_64B918B6C54C8C93 ON stand');
        $this->addSql('ALTER TABLE stand DROP type_id');
    }
}
