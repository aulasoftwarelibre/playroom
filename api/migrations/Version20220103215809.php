<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103215809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE room_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE room (id INT NOT NULL, name VARCHAR(180) NOT NULL, slug VARCHAR(180) NOT NULL, description VARCHAR(200) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_original_name VARCHAR(255) DEFAULT NULL, image_mime_type VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, image_dimensions TEXT DEFAULT NULL, avatar_name VARCHAR(255) DEFAULT NULL, avatar_original_name VARCHAR(255) DEFAULT NULL, avatar_mime_type VARCHAR(255) DEFAULT NULL, avatar_size INT DEFAULT NULL, avatar_dimensions TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_729F519B5E237E06 ON room (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_729F519B989D9B62 ON room (slug)');
        $this->addSql('COMMENT ON COLUMN room.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN room.image_dimensions IS \'(DC2Type:simple_array)\'');
        $this->addSql('COMMENT ON COLUMN room.avatar_dimensions IS \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE room_id_seq CASCADE');
        $this->addSql('DROP TABLE room');
    }
}
