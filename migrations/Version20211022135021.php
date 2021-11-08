<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022135021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_stand (forum_id INT NOT NULL, stand_id INT NOT NULL, INDEX IDX_7CCDBE6129CCBAD0 (forum_id), INDEX IDX_7CCDBE619734D487 (stand_id), PRIMARY KEY(forum_id, stand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stand (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stand_entreprise (stand_id INT NOT NULL, entreprise_id INT NOT NULL, INDEX IDX_5D73A7439734D487 (stand_id), INDEX IDX_5D73A743A4AEAFEA (entreprise_id), PRIMARY KEY(stand_id, entreprise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum_stand ADD CONSTRAINT FK_7CCDBE6129CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forum_stand ADD CONSTRAINT FK_7CCDBE619734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stand_entreprise ADD CONSTRAINT FK_5D73A7439734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stand_entreprise ADD CONSTRAINT FK_5D73A743A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forum DROP nombre_stands');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stand_entreprise DROP FOREIGN KEY FK_5D73A743A4AEAFEA');
        $this->addSql('ALTER TABLE forum_stand DROP FOREIGN KEY FK_7CCDBE619734D487');
        $this->addSql('ALTER TABLE stand_entreprise DROP FOREIGN KEY FK_5D73A7439734D487');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE forum_stand');
        $this->addSql('DROP TABLE stand');
        $this->addSql('DROP TABLE stand_entreprise');
        $this->addSql('ALTER TABLE forum ADD nombre_stands INT DEFAULT NULL');
    }
}
