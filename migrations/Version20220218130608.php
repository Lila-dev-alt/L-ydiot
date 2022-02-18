<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220218130608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account ALTER account_id TYPE UUID');
        $this->addSql('ALTER TABLE account ALTER account_id DROP DEFAULT');
        $this->addSql('ALTER TABLE account ALTER nom_compte SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN account.account_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE "user" ALTER name SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE account ALTER account_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE account ALTER account_id DROP DEFAULT');
        $this->addSql('ALTER TABLE account ALTER nom_compte DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN account.account_id IS NULL');
        $this->addSql('ALTER TABLE "user" ALTER name DROP NOT NULL');
    }
}
