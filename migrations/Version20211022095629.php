<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022095629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, opening_statut_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, nombre_stands INT DEFAULT NULL, date_ouverture DATETIME DEFAULT NULL, date_fermeture DATETIME DEFAULT NULL, statut TINYINT(1) DEFAULT NULL, date_fermeture_candidature DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_852BBECDFCCD1ACA (opening_statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pavillon (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, INDEX IDX_D5B8B380C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECDFCCD1ACA FOREIGN KEY (opening_statut_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE pavillon ADD CONSTRAINT FK_D5B8B380C54C8C93 FOREIGN KEY (type_id) REFERENCES dictionnaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE pavillon');
    }
}
