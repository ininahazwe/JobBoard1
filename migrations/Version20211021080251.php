<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021080251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile ADD type_diplome_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F3BFB8FC7 FOREIGN KEY (type_diplome_id) REFERENCES dictionnaire (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F3BFB8FC7 ON profile (type_diplome_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F3BFB8FC7');
        $this->addSql('DROP INDEX IDX_8157AA0F3BFB8FC7 ON profile');
        $this->addSql('ALTER TABLE profile DROP type_diplome_id');
    }
}
