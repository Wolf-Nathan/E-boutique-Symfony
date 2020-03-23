<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323134340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE media ADD jeux_id INT DEFAULT NULL, ADD console_id INT DEFAULT NULL, ADD console_modele_id INT DEFAULT NULL, ADD marque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CEC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C72F9DD9F FOREIGN KEY (console_id) REFERENCES console (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4022B67B FOREIGN KEY (console_modele_id) REFERENCES console_modele (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10CEC2AA9D2 ON media (jeux_id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C72F9DD9F ON media (console_id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C4022B67B ON media (console_modele_id)');
        $this->addSql('CREATE INDEX IDX_6A2CA10C4827B9B2 ON media (marque_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CEC2AA9D2');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C72F9DD9F');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4022B67B');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10C4827B9B2');
        $this->addSql('DROP INDEX IDX_6A2CA10CEC2AA9D2 ON media');
        $this->addSql('DROP INDEX IDX_6A2CA10C72F9DD9F ON media');
        $this->addSql('DROP INDEX IDX_6A2CA10C4022B67B ON media');
        $this->addSql('DROP INDEX IDX_6A2CA10C4827B9B2 ON media');
        $this->addSql('ALTER TABLE media DROP jeux_id, DROP console_id, DROP console_modele_id, DROP marque_id');
    }
}
