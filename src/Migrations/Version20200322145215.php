<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322145215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE jeux_console (jeux_id INT NOT NULL, console_id INT NOT NULL, INDEX IDX_E441A6CFEC2AA9D2 (jeux_id), INDEX IDX_E441A6CF72F9DD9F (console_id), PRIMARY KEY(jeux_id, console_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jeux_console ADD CONSTRAINT FK_E441A6CFEC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeux_console ADD CONSTRAINT FK_E441A6CF72F9DD9F FOREIGN KEY (console_id) REFERENCES console (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeux ADD marque_id INT NOT NULL');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_3755B50D4827B9B2 ON jeux (marque_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE jeux_console');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D4827B9B2');
        $this->addSql('DROP INDEX IDX_3755B50D4827B9B2 ON jeux');
        $this->addSql('ALTER TABLE jeux DROP marque_id');
    }
}
