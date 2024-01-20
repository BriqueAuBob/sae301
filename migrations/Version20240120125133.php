<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120125133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `check` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, homework_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_3C8EAC13A76ED395 (user_id), INDEX IDX_3C8EAC13B203DDE5 (homework_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, homework_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526CB203DDE5 (homework_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, name_code VARCHAR(5) NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE email (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_E7927C74A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE homework (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, subject_id INT NOT NULL, year INT NOT NULL, `group` VARCHAR(1) NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, due_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, teacher VARCHAR(255) NOT NULL, platform VARCHAR(255) NOT NULL, is_verified TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_8C600B4EF675F31B (author_id), INDEX IDX_8C600B4E23EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(30) NOT NULL, message VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, name_code VARCHAR(5) NOT NULL, name VARCHAR(100) NOT NULL, color VARCHAR(6) DEFAULT NULL, INDEX IDX_FBCE3E7A591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, homework_id INT NOT NULL, author_id INT NOT NULL, message VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_97A0ADA3B203DDE5 (homework_id), INDEX IDX_97A0ADA3F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, course_id INT NOT NULL, firstname VARCHAR(20) DEFAULT NULL, lastname VARCHAR(20) DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, year INT NOT NULL, `group` VARCHAR(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `check` ADD CONSTRAINT FK_3C8EAC13A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `check` ADD CONSTRAINT FK_3C8EAC13B203DDE5 FOREIGN KEY (homework_id) REFERENCES homework (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB203DDE5 FOREIGN KEY (homework_id) REFERENCES homework (id)');
        $this->addSql('ALTER TABLE email ADD CONSTRAINT FK_E7927C74A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE homework ADD CONSTRAINT FK_8C600B4EF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE homework ADD CONSTRAINT FK_8C600B4E23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3B203DDE5 FOREIGN KEY (homework_id) REFERENCES homework (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `check` DROP FOREIGN KEY FK_3C8EAC13A76ED395');
        $this->addSql('ALTER TABLE `check` DROP FOREIGN KEY FK_3C8EAC13B203DDE5');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB203DDE5');
        $this->addSql('ALTER TABLE email DROP FOREIGN KEY FK_E7927C74A76ED395');
        $this->addSql('ALTER TABLE homework DROP FOREIGN KEY FK_8C600B4EF675F31B');
        $this->addSql('ALTER TABLE homework DROP FOREIGN KEY FK_8C600B4E23EDC87');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE subject DROP FOREIGN KEY FK_FBCE3E7A591CC992');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3B203DDE5');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F675F31B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649591CC992');
        $this->addSql('DROP TABLE `check`');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE email');
        $this->addSql('DROP TABLE homework');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
