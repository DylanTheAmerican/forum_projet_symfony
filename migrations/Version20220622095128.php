<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622095128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic_answer DROP FOREIGN KEY FK_79DA79FD80988CEC');
        $this->addSql('ALTER TABLE topic_answer CHANGE topic_id topic_id INT NOT NULL');
        $this->addSql('ALTER TABLE topic_answer ADD CONSTRAINT FK_79DA79FD80988CEC FOREIGN KEY (parent_topic_id) REFERENCES topic_answer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE topic_answer DROP FOREIGN KEY FK_79DA79FD80988CEC');
        $this->addSql('ALTER TABLE topic_answer CHANGE topic_id topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topic_answer ADD CONSTRAINT FK_79DA79FD80988CEC FOREIGN KEY (parent_topic_id) REFERENCES topic_answer (id)');
    }
}
