<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190226205334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE market_order_location (id INT AUTO_INCREMENT NOT NULL, location_type INT DEFAULT NULL, city VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, post_index INT NOT NULL, home_number INT DEFAULT NULL, apartment_number INT DEFAULT NULL, INDEX IDX_EE29855DCDAE269 (location_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_order_delivery_way (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_order_location_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marker_order (id INT AUTO_INCREMENT NOT NULL, client_info_id INT DEFAULT NULL, location_id INT DEFAULT NULL, delivery_way_id INT DEFAULT NULL, promo_code_id INT DEFAULT NULL, order_date DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, total_cost INT NOT NULL, order_cost INT NOT NULL, delivery_cost INT NOT NULL, INDEX IDX_5DD719D7FB68585 (client_info_id), INDEX IDX_5DD719D764D218E (location_id), INDEX IDX_5DD719D79291C89D (delivery_way_id), INDEX IDX_5DD719D72FAE4625 (promo_code_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_ordered_products (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, product_id INT DEFAULT NULL, INDEX IDX_A49D05708D9F6D38 (order_id), INDEX IDX_A49D05704584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_order_promo_code (id INT AUTO_INCREMENT NOT NULL, promo_hash VARCHAR(255) DEFAULT NULL, marks INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_order_client_info (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE market_order_location ADD CONSTRAINT FK_EE29855DCDAE269 FOREIGN KEY (location_type) REFERENCES market_order_location_type (id)');
        $this->addSql('ALTER TABLE marker_order ADD CONSTRAINT FK_5DD719D7FB68585 FOREIGN KEY (client_info_id) REFERENCES market_order_client_info (id)');
        $this->addSql('ALTER TABLE marker_order ADD CONSTRAINT FK_5DD719D764D218E FOREIGN KEY (location_id) REFERENCES market_order_location (id)');
        $this->addSql('ALTER TABLE marker_order ADD CONSTRAINT FK_5DD719D79291C89D FOREIGN KEY (delivery_way_id) REFERENCES market_order_delivery_way (id)');
        $this->addSql('ALTER TABLE marker_order ADD CONSTRAINT FK_5DD719D72FAE4625 FOREIGN KEY (promo_code_id) REFERENCES market_order_promo_code (id)');
        $this->addSql('ALTER TABLE market_ordered_products ADD CONSTRAINT FK_A49D05708D9F6D38 FOREIGN KEY (order_id) REFERENCES marker_order (id)');
        $this->addSql('ALTER TABLE market_ordered_products ADD CONSTRAINT FK_A49D05704584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE marker_order DROP FOREIGN KEY FK_5DD719D764D218E');
        $this->addSql('ALTER TABLE marker_order DROP FOREIGN KEY FK_5DD719D79291C89D');
        $this->addSql('ALTER TABLE market_order_location DROP FOREIGN KEY FK_EE29855DCDAE269');
        $this->addSql('ALTER TABLE market_ordered_products DROP FOREIGN KEY FK_A49D05708D9F6D38');
        $this->addSql('ALTER TABLE marker_order DROP FOREIGN KEY FK_5DD719D72FAE4625');
        $this->addSql('ALTER TABLE marker_order DROP FOREIGN KEY FK_5DD719D7FB68585');
        $this->addSql('DROP TABLE market_order_location');
        $this->addSql('DROP TABLE market_order_delivery_way');
        $this->addSql('DROP TABLE market_order_location_type');
        $this->addSql('DROP TABLE marker_order');
        $this->addSql('DROP TABLE market_ordered_products');
        $this->addSql('DROP TABLE market_order_promo_code');
        $this->addSql('DROP TABLE market_order_client_info');
    }
}
