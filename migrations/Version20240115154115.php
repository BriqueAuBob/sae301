<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115154115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE email DROP FOREIGN KEY FK_E7927C749D86650F');
        $this->addSql('DROP INDEX IDX_E7927C749D86650F ON email');
        $this->addSql('ALTER TABLE email CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C74A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E7927C74A76ED395 ON email (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE email DROP FOREIGN KEY FK_E7927C74A76ED395');
        $this->addSql('DROP INDEX IDX_E7927C74A76ED395 ON email');
        $this->addSql('ALTER TABLE email CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C749D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E7927C749D86650F ON email (user_id_id)');
    }
}
