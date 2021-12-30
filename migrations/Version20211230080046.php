<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230080046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, course VARCHAR(255) NOT NULL, classname VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom_teacher (classroom_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_3A0767FD6278D5A8 (classroom_id), INDEX IDX_3A0767FD41807E1D (teacher_id), PRIMARY KEY(classroom_id, teacher_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, course_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, course_id INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_169E6FB96628AD36 (course_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, club_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, phone INT NOT NULL, INDEX IDX_B723AF3361190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(35) NOT NULL, dob DATE NOT NULL, email VARCHAR(50) NOT NULL, phone INT NOT NULL, address VARCHAR(50) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classroom_teacher ADD CONSTRAINT FK_3A0767FD6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classroom_teacher ADD CONSTRAINT FK_3A0767FD41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB96628AD36 FOREIGN KEY (course_category_id) REFERENCES course_category (id)');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF3361190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom_teacher DROP FOREIGN KEY FK_3A0767FD6278D5A8');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF3361190A32');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB96628AD36');
        $this->addSql('ALTER TABLE classroom_teacher DROP FOREIGN KEY FK_3A0767FD41807E1D');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE classroom_teacher');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_category');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE user');
    }
}
