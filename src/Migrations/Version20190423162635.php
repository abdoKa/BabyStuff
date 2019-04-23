<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190423162635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_497DD634989D9B62 ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE slug slug_categorie VARCHAR(170) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD634F191E6FC ON categorie (slug_categorie)');
        $this->addSql('DROP INDEX UNIQ_5EE7ECCE989D9B62 ON fourniseur');
        $this->addSql('ALTER TABLE fourniseur CHANGE slug slug_fournissuer VARCHAR(170) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5EE7ECCE4580AE15 ON fourniseur (slug_fournissuer)');
        $this->addSql('DROP INDEX UNIQ_29A5EC27989D9B62 ON produit');
        $this->addSql('ALTER TABLE produit CHANGE slug slug_produit VARCHAR(170) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC2721C1DE44 ON produit (referance)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC276262E116 ON produit (slug_produit)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_497DD634F191E6FC ON categorie');
        $this->addSql('ALTER TABLE categorie CHANGE slug_categorie slug VARCHAR(170) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD634989D9B62 ON categorie (slug)');
        $this->addSql('DROP INDEX UNIQ_5EE7ECCE4580AE15 ON fourniseur');
        $this->addSql('ALTER TABLE fourniseur CHANGE slug_fournissuer slug VARCHAR(170) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5EE7ECCE989D9B62 ON fourniseur (slug)');
        $this->addSql('DROP INDEX UNIQ_29A5EC2721C1DE44 ON produit');
        $this->addSql('DROP INDEX UNIQ_29A5EC276262E116 ON produit');
        $this->addSql('ALTER TABLE produit CHANGE slug_produit slug VARCHAR(170) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC27989D9B62 ON produit (slug)');
    }
}
