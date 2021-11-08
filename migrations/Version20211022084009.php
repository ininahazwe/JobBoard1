<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022084009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile ADD langues_id INT DEFAULT NULL, ADD niveau_id INT DEFAULT NULL, ADD zonegeographique_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F28EAE92 FOREIGN KEY (langues_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FB3E9C81 FOREIGN KEY (niveau_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FAEA9E14 FOREIGN KEY (zonegeographique_id) REFERENCES dictionnaire (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F28EAE92 ON profile (langues_id)');
        $this->addSql('CREATE INDEX IDX_8157AA0FB3E9C81 ON profile (niveau_id)');
        $this->addSql('CREATE INDEX IDX_8157AA0FAEA9E14 ON profile (zonegeographique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F28EAE92');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FB3E9C81');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FAEA9E14');
        $this->addSql('DROP INDEX IDX_8157AA0F28EAE92 ON profile');
        $this->addSql('DROP INDEX IDX_8157AA0FB3E9C81 ON profile');
        $this->addSql('DROP INDEX IDX_8157AA0FAEA9E14 ON profile');
        $this->addSql('ALTER TABLE profile DROP langues_id, DROP niveau_id, DROP zonegeographique_id');
    }
}
