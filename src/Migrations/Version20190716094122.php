<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190716094122 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_shipment ADD inventory_source_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_shipment ADD CONSTRAINT FK_FD707B331280F509 FOREIGN KEY (inventory_source_id) REFERENCES sylius_plus_inventory_source (id)');
        $this->addSql('CREATE INDEX IDX_FD707B331280F509 ON sylius_shipment (inventory_source_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_shipment DROP FOREIGN KEY FK_FD707B331280F509');
        $this->addSql('DROP INDEX IDX_FD707B331280F509 ON sylius_shipment');
        $this->addSql('ALTER TABLE sylius_shipment DROP inventory_source_id');
    }
}
