<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230072000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classroom_teacher (classroom_id INT NOT NULL, teacher_id INT NOT NULL, INDEX IDX_3A0767FD6278D5A8 (classroom_id), INDEX IDX_3A0767FD41807E1D (teacher_id), PRIMARY KEY(classroom_id, teacher_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classroom_teacher ADD CONSTRAINT FK_3A0767FD6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classroom_teacher ADD CONSTRAINT FK_3A0767FD41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE course_classroom');
        $this->addSql('DROP TABLE teacher_classroom');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_classroom (course_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_CBDC7031591CC992 (course_id), INDEX IDX_CBDC70316278D5A8 (classroom_id), PRIMARY KEY(course_id, classroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE teacher_classroom (teacher_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_33167C8641807E1D (teacher_id), INDEX IDX_33167C866278D5A8 (classroom_id), PRIMARY KEY(teacher_id, classroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE course_classroom ADD CONSTRAINT FK_CBDC7031591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_classroom ADD CONSTRAINT FK_CBDC70316278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_classroom ADD CONSTRAINT FK_33167C8641807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teacher_classroom ADD CONSTRAINT FK_33167C866278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE classroom_teacher');
    }
}
