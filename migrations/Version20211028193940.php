<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211028193940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE support ADD user_solver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE support ADD CONSTRAINT FK_8004EBA5BE859008 FOREIGN KEY (user_solver_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8004EBA5BE859008 ON support (user_solver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE support DROP FOREIGN KEY FK_8004EBA5BE859008');
        $this->addSql('DROP INDEX IDX_8004EBA5BE859008 ON support');
        $this->addSql('ALTER TABLE support DROP user_solver_id');
    }
}
