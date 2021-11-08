<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105084812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces_zone (annonce_id INT NOT NULL, dictionnaire_id INT NOT NULL, INDEX IDX_9A2DBECE8805AB2F (annonce_id), INDEX IDX_9A2DBECEE70AF195 (dictionnaire_id), PRIMARY KEY(annonce_id, dictionnaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonces_secteur (annonce_id INT NOT NULL, dictionnaire_id INT NOT NULL, INDEX IDX_DD80BB178805AB2F (annonce_id), INDEX IDX_DD80BB17E70AF195 (dictionnaire_id), PRIMARY KEY(annonce_id, dictionnaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonces_documents (annonce_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_7DDE1B068805AB2F (annonce_id), INDEX IDX_7DDE1B0693CB796C (file_id), PRIMARY KEY(annonce_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces_zone ADD CONSTRAINT FK_9A2DBECE8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_zone ADD CONSTRAINT FK_9A2DBECEE70AF195 FOREIGN KEY (dictionnaire_id) REFERENCES dictionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_secteur ADD CONSTRAINT FK_DD80BB178805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_secteur ADD CONSTRAINT FK_DD80BB17E70AF195 FOREIGN KEY (dictionnaire_id) REFERENCES dictionnaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_documents ADD CONSTRAINT FK_7DDE1B068805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_documents ADD CONSTRAINT FK_7DDE1B0693CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce DROP INDEX UNIQ_F65593E546E90E27, ADD INDEX IDX_F65593E546E90E27 (experience_id)');
        $this->addSql('ALTER TABLE annonce ADD diplome_id INT DEFAULT NULL, ADD contrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E526F859E2 FOREIGN KEY (diplome_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E51823061F FOREIGN KEY (contrat_id) REFERENCES dictionnaire (id)');
        $this->addSql('CREATE INDEX IDX_F65593E526F859E2 ON annonce (diplome_id)');
        $this->addSql('CREATE INDEX IDX_F65593E51823061F ON annonce (contrat_id)');
        $this->addSql('ALTER TABLE dictionnaire DROP FOREIGN KEY FK_AE6CDAFF810A9186');
        $this->addSql('ALTER TABLE dictionnaire DROP FOREIGN KEY FK_AE6CDAFF8805AB2F');
        $this->addSql('DROP INDEX IDX_AE6CDAFF8805AB2F ON dictionnaire');
        $this->addSql('DROP INDEX IDX_AE6CDAFF810A9186 ON dictionnaire');
        $this->addSql('ALTER TABLE dictionnaire DROP annonce_id, DROP annonce_secteur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annonces_zone');
        $this->addSql('DROP TABLE annonces_secteur');
        $this->addSql('DROP TABLE annonces_documents');
        $this->addSql('ALTER TABLE annonce DROP INDEX IDX_F65593E546E90E27, ADD UNIQUE INDEX UNIQ_F65593E546E90E27 (experience_id)');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E526F859E2');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E51823061F');
        $this->addSql('DROP INDEX IDX_F65593E526F859E2 ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E51823061F ON annonce');
        $this->addSql('ALTER TABLE annonce DROP diplome_id, DROP contrat_id');
        $this->addSql('ALTER TABLE dictionnaire ADD annonce_id INT DEFAULT NULL, ADD annonce_secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dictionnaire ADD CONSTRAINT FK_AE6CDAFF810A9186 FOREIGN KEY (annonce_secteur_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE dictionnaire ADD CONSTRAINT FK_AE6CDAFF8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_AE6CDAFF8805AB2F ON dictionnaire (annonce_id)');
        $this->addSql('CREATE INDEX IDX_AE6CDAFF810A9186 ON dictionnaire (annonce_secteur_id)');
    }
}
