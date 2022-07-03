<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701174533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture ADD type_voiture_id INT NOT NULL');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810F1C827E9F FOREIGN KEY (type_voiture_id) REFERENCES type_voiture (id)');
        $this->addSql('CREATE INDEX IDX_E9E2810F1C827E9F ON voiture (type_voiture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810F1C827E9F');
        $this->addSql('DROP INDEX IDX_E9E2810F1C827E9F ON voiture');
        $this->addSql('ALTER TABLE voiture DROP type_voiture_id');
    }
}
