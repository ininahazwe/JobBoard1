<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211102091039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, experience_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, reference VARCHAR(255) DEFAULT NULL, nombre_postes INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, qualites LONGTEXT DEFAULT NULL, salaire VARCHAR(255) DEFAULT NULL, horaires VARCHAR(255) DEFAULT NULL, adresse LONGTEXT DEFAULT NULL, avantages LONGTEXT NOT NULL, accessibilite TINYINT(1) DEFAULT NULL, statut TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX UNIQ_F65593E546E90E27 (experience_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_forum (annonce_id INT NOT NULL, forum_id INT NOT NULL, INDEX IDX_92A675528805AB2F (annonce_id), INDEX IDX_92A6755229CCBAD0 (forum_id), PRIMARY KEY(annonce_id, forum_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_stand (annonce_id INT NOT NULL, stand_id INT NOT NULL, INDEX IDX_7334D3298805AB2F (annonce_id), INDEX IDX_7334D3299734D487 (stand_id), PRIMARY KEY(annonce_id, stand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E546E90E27 FOREIGN KEY (experience_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE annonce_forum ADD CONSTRAINT FK_92A675528805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_forum ADD CONSTRAINT FK_92A6755229CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_stand ADD CONSTRAINT FK_7334D3298805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_stand ADD CONSTRAINT FK_7334D3299734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dictionnaire ADD annonce_id INT DEFAULT NULL, ADD annonce_secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dictionnaire ADD CONSTRAINT FK_AE6CDAFF8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE dictionnaire ADD CONSTRAINT FK_AE6CDAFF810A9186 FOREIGN KEY (annonce_secteur_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_AE6CDAFF8805AB2F ON dictionnaire (annonce_id)');
        $this->addSql('CREATE INDEX IDX_AE6CDAFF810A9186 ON dictionnaire (annonce_secteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce_forum DROP FOREIGN KEY FK_92A675528805AB2F');
        $this->addSql('ALTER TABLE annonce_stand DROP FOREIGN KEY FK_7334D3298805AB2F');
        $this->addSql('ALTER TABLE dictionnaire DROP FOREIGN KEY FK_AE6CDAFF8805AB2F');
        $this->addSql('ALTER TABLE dictionnaire DROP FOREIGN KEY FK_AE6CDAFF810A9186');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE annonce_forum');
        $this->addSql('DROP TABLE annonce_stand');
        $this->addSql('DROP INDEX IDX_AE6CDAFF8805AB2F ON dictionnaire');
        $this->addSql('DROP INDEX IDX_AE6CDAFF810A9186 ON dictionnaire');
        $this->addSql('ALTER TABLE dictionnaire DROP annonce_id, DROP annonce_secteur_id');
    }
}
