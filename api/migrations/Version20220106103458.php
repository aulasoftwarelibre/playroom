<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106103458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE degree_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE degree (id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, type VARCHAR(16) NOT NULL, family VARCHAR(16) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A7A36D635E237E06 ON degree (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A7A36D63989D9B62 ON degree (slug)');
        $this->addSql('COMMENT ON COLUMN degree.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE member ADD degree_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78B35C5756 FOREIGN KEY (degree_id) REFERENCES degree (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_70E4FA78B35C5756 ON member (degree_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member DROP CONSTRAINT FK_70E4FA78B35C5756');
        $this->addSql('DROP SEQUENCE degree_id_seq CASCADE');
        $this->addSql('DROP TABLE degree');
        $this->addSql('DROP INDEX IDX_70E4FA78B35C5756');
        $this->addSql('ALTER TABLE member DROP degree_id');
    }
}
