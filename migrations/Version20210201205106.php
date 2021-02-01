<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201205106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !="sqlite", "Migration faild. Não é sqlite");
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medico (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, crm INTEGER NOT NULL, nome VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !="sqlite", "Migration faild. Não é sqlite");
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE medico');
    }
}
