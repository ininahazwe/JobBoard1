<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211025080043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE forum ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pavillon ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE stand ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise DROP slug');
        $this->addSql('ALTER TABLE forum DROP slug');
        $this->addSql('ALTER TABLE pavillon DROP slug');
        $this->addSql('ALTER TABLE stand DROP slug');
    }
}
