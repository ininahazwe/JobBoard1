<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103160425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stand ADD logo_id INT DEFAULT NULL, ADD url VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD page_offres LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE stand ADD CONSTRAINT FK_64B918B6F98F144A FOREIGN KEY (logo_id) REFERENCES file (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64B918B6F98F144A ON stand (logo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stand DROP FOREIGN KEY FK_64B918B6F98F144A');
        $this->addSql('DROP INDEX UNIQ_64B918B6F98F144A ON stand');
        $this->addSql('ALTER TABLE stand DROP logo_id, DROP url, DROP description, DROP page_offres');
    }
}
