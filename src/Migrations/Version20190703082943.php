<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190703082943 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('INSERT INTO sylius_plus_inventory_source (id, code, name) VALUES (1, \'default\', \'Default\')');

        $this->addSql('
            INSERT INTO sylius_plus_inventory_source_stock (product_variant_id, inventory_source_code, on_hand, on_hold)
            SELECT id, \'default\', on_hand, on_hold 
            FROM sylius_product_variant
            WHERE tracked = 1
            AND (SELECT COUNT(*) FROM sylius_plus_inventory_source WHERE code = \'default\') > 0
        ');

        $this->addSql('
            INSERT INTO sylius_plus_inventory_source_channels (inventory_source_id, channel_id)
            SELECT 1, id 
            FROM sylius_channel
            WHERE (SELECT COUNT(*) FROM sylius_plus_inventory_source WHERE code = \'default\') > 0
        ');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM sylius_plus_inventory_source WHERE code = \'default\'');
        $this->addSql('DELETE FROM sylius_plus_inventory_source_channels WHERE inventory_source_id = 1');
        $this->addSql('DELETE FROM sylius_plus_inventory_source_stock WHERE inventory_source_code = \'default\'');
    }
}
