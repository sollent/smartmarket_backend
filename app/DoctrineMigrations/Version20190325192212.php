<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190325192212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950514FB831');
        $this->addSql('DROP INDEX UNIQ_1DD39950514FB831 ON news');
        $this->addSql('ALTER TABLE news DROP seo_information_id');
        $this->addSql('ALTER TABLE news_seo ADD news_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news_seo ADD CONSTRAINT FK_D1C68312B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('CREATE INDEX IDX_D1C68312B5A459A0 ON news_seo (news_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE news ADD seo_information_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950514FB831 FOREIGN KEY (seo_information_id) REFERENCES news_seo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD39950514FB831 ON news (seo_information_id)');
        $this->addSql('ALTER TABLE news_seo DROP FOREIGN KEY FK_D1C68312B5A459A0');
        $this->addSql('DROP INDEX IDX_D1C68312B5A459A0 ON news_seo');
        $this->addSql('ALTER TABLE news_seo DROP news_id');
    }
}
