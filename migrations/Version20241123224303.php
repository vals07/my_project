<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123224303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developer ADD birth_date DATE NOT NULL DEFAULT \'01.01.1970\'');
        $this->addSql('ALTER TABLE developer ADD hire_date DATE NOT NULL DEFAULT \'01.01.1970\'');
        $this->addSql('ALTER TABLE developer ADD fire_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD open_date DATE NOT NULL DEFAULT \'01.01.1970\'');
        $this->addSql('ALTER TABLE project ADD close_date DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE project DROP open_date');
        $this->addSql('ALTER TABLE project DROP close_date');
        $this->addSql('ALTER TABLE developer DROP birth_date');
        $this->addSql('ALTER TABLE developer DROP hire_date');
        $this->addSql('ALTER TABLE developer DROP fire_date');
    }
}
