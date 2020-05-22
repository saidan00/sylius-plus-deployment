<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190614053321 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_plus_inventory_source_channels (inventory_source_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_9ED7D9201280F509 (inventory_source_id), INDEX IDX_9ED7D92072F5A1AA (channel_id), PRIMARY KEY(inventory_source_id, channel_id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_plus_inventory_source_channels ADD CONSTRAINT FK_9ED7D9201280F509 FOREIGN KEY (inventory_source_id) REFERENCES sylius_plus_inventory_source (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_plus_inventory_source_channels ADD CONSTRAINT FK_9ED7D92072F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sylius_plus_inventory_source_channels');
    }
}
