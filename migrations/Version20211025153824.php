<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025153824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile ADD experiences_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F423DE140 FOREIGN KEY (experiences_id) REFERENCES dictionnaire (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F423DE140 ON profile (experiences_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F423DE140');
        $this->addSql('DROP INDEX IDX_8157AA0F423DE140 ON profile');
        $this->addSql('ALTER TABLE profile DROP experiences_id');
    }
}
