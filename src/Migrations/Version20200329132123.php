<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200329132123 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, adresse_id INT DEFAULT NULL, valid TINYINT(1) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), INDEX IDX_6EEAA67D4DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_line (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, jeu_id INT DEFAULT NULL, console_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_BA78B51582EA2E54 (commande_id), INDEX IDX_BA78B5158C9E392E (jeu_id), INDEX IDX_BA78B51572F9DD9F (console_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE commande_line ADD CONSTRAINT FK_BA78B51582EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_line ADD CONSTRAINT FK_BA78B5158C9E392E FOREIGN KEY (jeu_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE commande_line ADD CONSTRAINT FK_BA78B51572F9DD9F FOREIGN KEY (console_id) REFERENCES console_modele (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande_line DROP FOREIGN KEY FK_BA78B51582EA2E54');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_line');
    }
}
