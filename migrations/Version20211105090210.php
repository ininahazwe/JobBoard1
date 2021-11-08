<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105090210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annonces_documents');
        $this->addSql('ALTER TABLE file ADD annonce_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36108805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_8C9F36108805AB2F ON file (annonce_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces_documents (annonce_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_7DDE1B068805AB2F (annonce_id), INDEX IDX_7DDE1B0693CB796C (file_id), PRIMARY KEY(annonce_id, file_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE annonces_documents ADD CONSTRAINT FK_7DDE1B068805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_documents ADD CONSTRAINT FK_7DDE1B0693CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36108805AB2F');
        $this->addSql('DROP INDEX IDX_8C9F36108805AB2F ON file');
        $this->addSql('ALTER TABLE file DROP annonce_id');
    }
}
