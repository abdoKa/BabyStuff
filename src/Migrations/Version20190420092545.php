<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190420092545 extends AbstractMigration
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
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD634989D9B62 ON categorie (slug)');
        $this->addSql('ALTER TABLE fourniseur CHANGE slug slug VARCHAR(170) NOT NULL, CHANGE date_ajoute date_ajout DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5EE7ECCE989D9B62 ON fourniseur (slug)');
        $this->addSql('ALTER TABLE produit CHANGE slug slug VARCHAR(170) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC27989D9B62 ON produit (slug)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_497DD634989D9B62 ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('DROP INDEX UNIQ_5EE7ECCE989D9B62 ON fourniseur');
        $this->addSql('ALTER TABLE fourniseur CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE date_ajout date_ajoute DATETIME NOT NULL');
        $this->addSql('DROP INDEX UNIQ_29A5EC27989D9B62 ON produit');
        $this->addSql('ALTER TABLE produit CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
