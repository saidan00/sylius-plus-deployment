<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190708063521 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_plus_inventory_source_stock ADD inventory_source_id INT DEFAULT NULL, DROP inventory_source_code');
        $this->addSql('ALTER TABLE sylius_plus_inventory_source_stock ADD CONSTRAINT FK_7FD5018D1280F509 FOREIGN KEY (inventory_source_id) REFERENCES sylius_plus_inventory_source (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_7FD5018D1280F509 ON sylius_plus_inventory_source_stock (inventory_source_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7FD5018DA80EF6841280F509 ON sylius_plus_inventory_source_stock (product_variant_id, inventory_source_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_plus_inventory_source_stock DROP FOREIGN KEY FK_7FD5018D1280F509');
        $this->addSql('DROP INDEX IDX_7FD5018D1280F509 ON sylius_plus_inventory_source_stock');
        $this->addSql('DROP INDEX UNIQ_7FD5018DA80EF6841280F509 ON sylius_plus_inventory_source_stock');
        $this->addSql('ALTER TABLE sylius_plus_inventory_source_stock ADD inventory_source_code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP inventory_source_id');
    }
}
