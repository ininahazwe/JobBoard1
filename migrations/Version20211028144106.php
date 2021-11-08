<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211028144106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, faq_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, is_statut TINYINT(1) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_C0155143C54C8C93 (type_id), INDEX IDX_C015514381BEC8C2 (faq_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143C54C8C93 FOREIGN KEY (type_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C015514381BEC8C2 FOREIGN KEY (faq_id) REFERENCES dictionnaire (id)');
        $this->addSql('ALTER TABLE file ADD blog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id)');
        $this->addSql('CREATE INDEX IDX_8C9F3610DAE07E97 ON file (blog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610DAE07E97');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP INDEX IDX_8C9F3610DAE07E97 ON file');
        $this->addSql('ALTER TABLE file DROP blog_id');
    }
}
