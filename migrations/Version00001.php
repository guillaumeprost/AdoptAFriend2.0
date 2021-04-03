<?php

namespace DoctrineMigration;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Migrations\Exception\MigrationException;

/**
 * First Migration
 *
 * Class Version00001
 * @package DoctrineMigration
 */
class Version00001 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE offer (id INT NOT NULL, title VARCHAR(255) NOT NULL, animal_type VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, address1 VARCHAR(255) DEFAULT NULL, address2 VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, department VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, views INT NOT NULL, PRIMARY KEY(id));');
        $this->addSql('CREATE TABLE animal (id INT NOT NULL, offer_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, birth_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, weight VARCHAR(255) DEFAULT NULL, vaccination VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, discriminator VARCHAR(255) NOT NULL, PRIMARY KEY(id));');
        $this->addSql('CREATE INDEX IDX_6AAB231F53C674EE ON animal (offer_id);');
        $this->addSql('CREATE SEQUENCE offer_id_seq INCREMENT BY 1 MINVALUE 1 START 1;');
        $this->addSql('CREATE SEQUENCE animal_id_seq INCREMENT BY 1 MINVALUE 1 START 1;');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F53C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) NOT DEFERRABLE INITIALLY IMMEDIATE;');
    }
}