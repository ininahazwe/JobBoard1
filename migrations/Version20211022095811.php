<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211022095811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum_pavillon (forum_id INT NOT NULL, pavillon_id INT NOT NULL, INDEX IDX_F24B3E6729CCBAD0 (forum_id), INDEX IDX_F24B3E678D2618A0 (pavillon_id), PRIMARY KEY(forum_id, pavillon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum_pavillon ADD CONSTRAINT FK_F24B3E6729CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forum_pavillon ADD CONSTRAINT FK_F24B3E678D2618A0 FOREIGN KEY (pavillon_id) REFERENCES pavillon (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE forum_pavillon');
    }
}
