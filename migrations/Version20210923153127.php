<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923153127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse ADD client_id INT NOT NULL, ADD pays VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, ADD code_postal VARCHAR(255) NOT NULL, ADD rue VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F081619EB6921 FOREIGN KEY (client_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C35F081619EB6921 ON adresse (client_id)');
        $this->addSql('ALTER TABLE user ADD nom_de_famille VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F081619EB6921');
        $this->addSql('DROP INDEX UNIQ_C35F081619EB6921 ON adresse');
        $this->addSql('ALTER TABLE adresse DROP client_id, DROP pays, DROP ville, DROP code_postal, DROP rue, DROP telephone');
        $this->addSql('ALTER TABLE user DROP nom_de_famille, DROP prenom');
    }
}
