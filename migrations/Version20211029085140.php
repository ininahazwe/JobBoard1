<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029085140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cvexperience (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, post VARCHAR(255) DEFAULT NULL, entreprise VARCHAR(255) DEFAULT NULL, debut DATETIME DEFAULT NULL, fin DATETIME DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_7A665491CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cvformation (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, etablissement VARCHAR(255) DEFAULT NULL, debut DATETIME DEFAULT NULL, fin DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_DCD808F3CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cvexperience ADD CONSTRAINT FK_7A665491CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE cvformation ADD CONSTRAINT FK_DCD808F3CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE file ADD cv_experience_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610E0964BB0 FOREIGN KEY (cv_experience_id) REFERENCES cvexperience (id)');
        $this->addSql('CREATE INDEX IDX_8C9F3610E0964BB0 ON file (cv_experience_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610E0964BB0');
        $this->addSql('DROP TABLE cvexperience');
        $this->addSql('DROP TABLE cvformation');
        $this->addSql('DROP INDEX IDX_8C9F3610E0964BB0 ON file');
        $this->addSql('ALTER TABLE file DROP cv_experience_id');
    }
}
