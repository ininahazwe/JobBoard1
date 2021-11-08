<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211104092459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file ADD stand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36109734D487 FOREIGN KEY (stand_id) REFERENCES stand (id)');
        $this->addSql('CREATE INDEX IDX_8C9F36109734D487 ON file (stand_id)');
        $this->addSql('ALTER TABLE stand DROP FOREIGN KEY FK_64B918B6F98F144A');
        $this->addSql('DROP INDEX UNIQ_64B918B6F98F144A ON stand');
        $this->addSql('ALTER TABLE stand DROP logo_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36109734D487');
        $this->addSql('DROP INDEX IDX_8C9F36109734D487 ON file');
        $this->addSql('ALTER TABLE file DROP stand_id');
        $this->addSql('ALTER TABLE stand ADD logo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE stand ADD CONSTRAINT FK_64B918B6F98F144A FOREIGN KEY (logo_id) REFERENCES file (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64B918B6F98F144A ON stand (logo_id)');
    }
}
