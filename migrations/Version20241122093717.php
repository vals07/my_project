<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241122093717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE developer (id SERIAL NOT NULL, full_name VARCHAR(500) NOT NULL, position VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(11) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE developer_project (developer_id INT NOT NULL, project_id INT NOT NULL, PRIMARY KEY(developer_id, project_id))');
        $this->addSql('CREATE INDEX IDX_412D364564DD9267 ON developer_project (developer_id)');
        $this->addSql('CREATE INDEX IDX_412D3645166D1F9C ON developer_project (project_id)');
        $this->addSql('CREATE TABLE project (id SERIAL NOT NULL, name VARCHAR(500) NOT NULL, client VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE developer_project ADD CONSTRAINT FK_412D364564DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE developer_project ADD CONSTRAINT FK_412D3645166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE developer_project DROP CONSTRAINT FK_412D364564DD9267');
        $this->addSql('ALTER TABLE developer_project DROP CONSTRAINT FK_412D3645166D1F9C');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE developer_project');
        $this->addSql('DROP TABLE project');
    }
}
