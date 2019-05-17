<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190206142352 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_photo (id INT AUTO_INCREMENT NOT NULL, product INT DEFAULT NULL, title VARCHAR(100) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_B5EBFF44D34A04AD (product), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_characteristic (id INT AUTO_INCREMENT NOT NULL, parent_section INT DEFAULT NULL, name VARCHAR(100) NOT NULL, value LONGTEXT NOT NULL, INDEX IDX_146D77C5F3B0EA9 (parent_section), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_characteristic_section (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_28C1E2474584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, product_color_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, price INT NOT NULL, available TINYINT(1) NOT NULL, short_description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, discount_status TINYINT(1) NOT NULL, discount_percent_value INT NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04ADB16A7522 (product_color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_photo ADD CONSTRAINT FK_B5EBFF44D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_characteristic ADD CONSTRAINT FK_146D77C5F3B0EA9 FOREIGN KEY (parent_section) REFERENCES product_characteristic_section (id)');
        $this->addSql('ALTER TABLE product_characteristic_section ADD CONSTRAINT FK_28C1E2474584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADB16A7522 FOREIGN KEY (product_color_id) REFERENCES product_color (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product_characteristic DROP FOREIGN KEY FK_146D77C5F3B0EA9');
        $this->addSql('ALTER TABLE product_photo DROP FOREIGN KEY FK_B5EBFF44D34A04AD');
        $this->addSql('ALTER TABLE product_characteristic_section DROP FOREIGN KEY FK_28C1E2474584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADB16A7522');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE product_photo');
        $this->addSql('DROP TABLE product_characteristic');
        $this->addSql('DROP TABLE product_characteristic_section');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_color');
    }
}
