<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020123444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361052B5672F');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP INDEX IDX_8C9F361052B5672F ON file');
        $this->addSql('ALTER TABLE file CHANGE c_v_id cv_candidat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361016AEEF7F FOREIGN KEY (cv_candidat_id) REFERENCES profile (id)');
        $this->addSql('CREATE INDEX IDX_8C9F361016AEEF7F ON file (cv_candidat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, nom VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_B66FFE92A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361016AEEF7F');
        $this->addSql('DROP INDEX IDX_8C9F361016AEEF7F ON file');
        $this->addSql('ALTER TABLE file CHANGE cv_candidat_id c_v_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361052B5672F FOREIGN KEY (c_v_id) REFERENCES cv (id)');
        $this->addSql('CREATE INDEX IDX_8C9F361052B5672F ON file (c_v_id)');
    }
}
