<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211013133334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dictionnaire (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, nom_fichier VARCHAR(255) NOT NULL, type INT DEFAULT NULL, nom_libre VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX IDX_8C9F3610CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE adresse ADD profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE INDEX IDX_C35F0816CCFA12B8 ON adresse (profile_id)');
        $this->addSql('ALTER TABLE profile ADD user_id INT NOT NULL, ADD type_contrat_id INT DEFAULT NULL, ADD secteur_activite_id INT DEFAULT NULL, ADD type_entretien_id INT DEFAULT NULL, ADD telephone VARCHAR(255) DEFAULT NULL, ADD recevoir_alertes_offres TINYINT(1) DEFAULT NULL, ADD is_cvtheque TINYINT(1) NOT NULL, ADD is_recevoir_alertes TINYINT(1) NOT NULL, ADD is_conditions_utilisation TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F520D03A FOREIGN KEY (type_contrat_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F5233A7FC FOREIGN KEY (secteur_activite_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FD3CE74A7 FOREIGN KEY (type_entretien_id) REFERENCES dictionnaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8157AA0FA76ED395 ON profile (user_id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F520D03A ON profile (type_contrat_id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F5233A7FC ON profile (secteur_activite_id)');
        $this->addSql('CREATE INDEX IDX_8157AA0FD3CE74A7 ON profile (type_entretien_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F520D03A');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F5233A7FC');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FD3CE74A7');
        $this->addSql('DROP TABLE dictionnaire');
        $this->addSql('DROP TABLE file');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816CCFA12B8');
        $this->addSql('DROP INDEX IDX_C35F0816CCFA12B8 ON adresse');
        $this->addSql('ALTER TABLE adresse DROP profile_id');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('DROP INDEX UNIQ_8157AA0FA76ED395 ON profile');
        $this->addSql('DROP INDEX IDX_8157AA0F520D03A ON profile');
        $this->addSql('DROP INDEX IDX_8157AA0F5233A7FC ON profile');
        $this->addSql('DROP INDEX IDX_8157AA0FD3CE74A7 ON profile');
        $this->addSql('ALTER TABLE profile DROP user_id, DROP type_contrat_id, DROP secteur_activite_id, DROP type_entretien_id, DROP telephone, DROP recevoir_alertes_offres, DROP is_cvtheque, DROP is_recevoir_alertes, DROP is_conditions_utilisation');
    }
}
