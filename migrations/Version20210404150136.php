<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210404150136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE animal_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE animal (id INT NOT NULL, name VARCHAR(255) NOT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, weight NUMERIC(10, 0) DEFAULT NULL, fur VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, vaccination BOOLEAN DEFAULT NULL, sterilized BOOLEAN NOT NULL, dewormed BOOLEAN NOT NULL, price NUMERIC(10, 0) DEFAULT NULL, description TEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, dogs_affinities VARCHAR(255) DEFAULT NULL, cats_affinities VARCHAR(255) DEFAULT NULL, child_affinities VARCHAR(255) DEFAULT NULL, discriminator VARCHAR(255) NOT NULL, size VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE animal_id_seq CASCADE');
        $this->addSql('DROP TABLE animal');
    }
}
