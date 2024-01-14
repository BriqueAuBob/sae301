<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111151501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, hw_id_id INT NOT NULL, author_id_id INT NOT NULL, status TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_97A0ADA3B5D59AA (hw_id_id), INDEX IDX_97A0ADA369CCBE9A (author_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B5D59AA FOREIGN KEY (hw_id_id) REFERENCES homework (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA369CCBE9A FOREIGN KEY (author_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3B5D59AA');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA369CCBE9A');
        $this->addSql('DROP TABLE ticket');
    }
}
