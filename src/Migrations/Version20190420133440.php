<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190420133440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE slug slug VARCHAR(170) NOT NULL');
        $this->addSql('ALTER TABLE fourniseur CHANGE slug slug VARCHAR(170) NOT NULL, CHANGE date_ajoute date_ajout DATETIME NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE slug slug VARCHAR(170) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE fourniseur CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE date_ajout date_ajoute DATETIME NOT NULL');
        $this->addSql('ALTER TABLE produit CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
