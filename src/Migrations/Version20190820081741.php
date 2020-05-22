<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190820081741 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_plus_inventory_source_address (id INT AUTO_INCREMENT NOT NULL, country_code VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_plus_inventory_source ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_plus_inventory_source ADD CONSTRAINT FK_96C48A62F5B7AF75 FOREIGN KEY (address_id) REFERENCES sylius_plus_inventory_source_address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_96C48A62F5B7AF75 ON sylius_plus_inventory_source (address_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_plus_inventory_source DROP FOREIGN KEY FK_96C48A62F5B7AF75');
        $this->addSql('DROP TABLE sylius_plus_inventory_source_address');
        $this->addSql('DROP INDEX UNIQ_96C48A62F5B7AF75 ON sylius_plus_inventory_source');
        $this->addSql('ALTER TABLE sylius_plus_inventory_source DROP address_id');
    }
}
