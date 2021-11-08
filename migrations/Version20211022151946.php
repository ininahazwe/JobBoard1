<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022151946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stand_entreprise');
        $this->addSql('ALTER TABLE stand ADD nom VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stand_entreprise (stand_id INT NOT NULL, entreprise_id INT NOT NULL, INDEX IDX_5D73A743A4AEAFEA (entreprise_id), INDEX IDX_5D73A7439734D487 (stand_id), PRIMARY KEY(stand_id, entreprise_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE stand_entreprise ADD CONSTRAINT FK_5D73A7439734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stand_entreprise ADD CONSTRAINT FK_5D73A743A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stand DROP nom');
    }
}
