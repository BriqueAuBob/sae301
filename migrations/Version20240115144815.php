<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115144815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA369CCBE9A');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3B5D59AA');
        $this->addSql('DROP INDEX IDX_97A0ADA369CCBE9A ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3B5D59AA ON ticket');
        $this->addSql('ALTER TABLE ticket ADD homework_id INT NOT NULL, ADD author_id INT NOT NULL, ADD message VARCHAR(255) DEFAULT NULL, DROP hw_id_id, DROP author_id_id');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B203DDE5 FOREIGN KEY (homework_id) REFERENCES homework (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3B203DDE5 ON ticket (homework_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3F675F31B ON ticket (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3B203DDE5');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F675F31B');
        $this->addSql('DROP INDEX IDX_97A0ADA3B203DDE5 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3F675F31B ON ticket');
        $this->addSql('ALTER TABLE ticket ADD hw_id_id INT NOT NULL, ADD author_id_id INT NOT NULL, DROP homework_id, DROP author_id, DROP message');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA369CCBE9A FOREIGN KEY (author_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B5D59AA FOREIGN KEY (hw_id_id) REFERENCES homework (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA369CCBE9A ON ticket (author_id_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3B5D59AA ON ticket (hw_id_id)');
    }
}
