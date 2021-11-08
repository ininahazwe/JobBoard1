<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105131738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annonce_forum');
        $this->addSql('DROP TABLE annonce_stand');
        $this->addSql('ALTER TABLE annonce ADD forum_id INT DEFAULT NULL, ADD stand_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E529CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E59734D487 FOREIGN KEY (stand_id) REFERENCES stand (id)');
        $this->addSql('CREATE INDEX IDX_F65593E529CCBAD0 ON annonce (forum_id)');
        $this->addSql('CREATE INDEX IDX_F65593E59734D487 ON annonce (stand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce_forum (annonce_id INT NOT NULL, forum_id INT NOT NULL, INDEX IDX_92A675528805AB2F (annonce_id), INDEX IDX_92A6755229CCBAD0 (forum_id), PRIMARY KEY(annonce_id, forum_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE annonce_stand (annonce_id INT NOT NULL, stand_id INT NOT NULL, INDEX IDX_7334D3298805AB2F (annonce_id), INDEX IDX_7334D3299734D487 (stand_id), PRIMARY KEY(annonce_id, stand_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE annonce_forum ADD CONSTRAINT FK_92A6755229CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_forum ADD CONSTRAINT FK_92A675528805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_stand ADD CONSTRAINT FK_7334D3298805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_stand ADD CONSTRAINT FK_7334D3299734D487 FOREIGN KEY (stand_id) REFERENCES stand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E529CCBAD0');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E59734D487');
        $this->addSql('DROP INDEX IDX_F65593E529CCBAD0 ON annonce');
        $this->addSql('DROP INDEX IDX_F65593E59734D487 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP forum_id, DROP stand_id');
    }
}
