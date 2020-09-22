<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200922142702 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clicks (id INT NOT NULL, link_id BIGINT NOT NULL, ip VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_20DA1901ADA40271 ON clicks (link_id)');
        $this->addSql('CREATE TABLE links (id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, redirect_url VARCHAR(255) NOT NULL, url_path VARCHAR(255) NOT NULL, is_active BOOLEAN DEFAULT \'true\' NOT NULL, is_favourite BOOLEAN DEFAULT \'false\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D182A118150042B7 ON links (url_path)');
        $this->addSql('CREATE INDEX IDX_D182A118A76ED395 ON links (user_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('ALTER TABLE clicks ADD CONSTRAINT FK_20DA1901ADA40271 FOREIGN KEY (link_id) REFERENCES links (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE links ADD CONSTRAINT FK_D182A118A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE clicks DROP CONSTRAINT FK_20DA1901ADA40271');
        $this->addSql('ALTER TABLE links DROP CONSTRAINT FK_D182A118A76ED395');
        $this->addSql('DROP TABLE clicks');
        $this->addSql('DROP TABLE links');
        $this->addSql('DROP TABLE users');
    }
}
