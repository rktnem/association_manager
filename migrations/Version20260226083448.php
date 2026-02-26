<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260226083448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_association ADD association_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_association ADD CONSTRAINT FK_549EE859EFB9C8A5 FOREIGN KEY (association_id) REFERENCES association (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_549EE859EFB9C8A5 ON user_association (association_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_association DROP FOREIGN KEY FK_549EE859EFB9C8A5');
        $this->addSql('DROP INDEX UNIQ_549EE859EFB9C8A5 ON user_association');
        $this->addSql('ALTER TABLE user_association DROP association_id');
    }
}
