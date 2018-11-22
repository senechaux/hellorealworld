<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122051727 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE phweep ADD COLUMN updated_at DATETIME NOT NULL DEFAULT "1970-01-01"');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__phweep AS SELECT id, message, image FROM phweep');
        $this->addSql('DROP TABLE phweep');
        $this->addSql('CREATE TABLE phweep (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, message VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO phweep (id, message, image) SELECT id, message, image FROM __temp__phweep');
        $this->addSql('DROP TABLE __temp__phweep');
    }
}
