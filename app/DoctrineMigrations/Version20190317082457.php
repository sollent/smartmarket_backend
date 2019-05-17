<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190317082457 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sub_category (id INT AUTO_INCREMENT NOT NULL, parent_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_BCE3F798796A8F92 (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news_sub_category (id INT AUTO_INCREMENT NOT NULL, parent_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_5AA99E2F796A8F92 (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE next_sub_category (id INT AUTO_INCREMENT NOT NULL, parent_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_6BECF772796A8F92 (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sub_category ADD CONSTRAINT FK_BCE3F798796A8F92 FOREIGN KEY (parent_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE news_sub_category ADD CONSTRAINT FK_5AA99E2F796A8F92 FOREIGN KEY (parent_category_id) REFERENCES news_category (id)');
        $this->addSql('ALTER TABLE next_sub_category ADD CONSTRAINT FK_6BECF772796A8F92 FOREIGN KEY (parent_category_id) REFERENCES sub_category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE next_sub_category DROP FOREIGN KEY FK_6BECF772796A8F92');
        $this->addSql('DROP TABLE sub_category');
        $this->addSql('DROP TABLE news_sub_category');
        $this->addSql('DROP TABLE next_sub_category');
    }
}
