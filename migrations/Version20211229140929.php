<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211229140929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_classroom (course_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_CBDC7031591CC992 (course_id), INDEX IDX_CBDC70316278D5A8 (classroom_id), PRIMARY KEY(course_id, classroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_classroom ADD CONSTRAINT FK_CBDC7031591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_classroom ADD CONSTRAINT FK_CBDC70316278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD course_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB96628AD36 FOREIGN KEY (course_category_id) REFERENCES course_category (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB96628AD36 ON course (course_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE course_classroom');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB96628AD36');
        $this->addSql('DROP INDEX IDX_169E6FB96628AD36 ON course');
        $this->addSql('ALTER TABLE course DROP course_category_id');
    }
}
