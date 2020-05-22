<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191002141932 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_plus_return_request_unit ADD CONSTRAINT FK_1A98A733F720C233 FOREIGN KEY (order_item_unit_id) REFERENCES sylius_order_item_unit (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_1A98A733F720C233 ON sylius_plus_return_request_unit (order_item_unit_id)');
        $this->addSql('ALTER TABLE sylius_order ADD CONSTRAINT FK_6196A1F989EA1297 FOREIGN KEY (return_request_id) REFERENCES sylius_plus_return_request (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6196A1F989EA1297 ON sylius_order (return_request_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_order DROP FOREIGN KEY FK_6196A1F989EA1297');
        $this->addSql('DROP INDEX IDX_6196A1F989EA1297 ON sylius_order');
        $this->addSql('ALTER TABLE sylius_plus_return_request_unit DROP FOREIGN KEY FK_1A98A733F720C233');
        $this->addSql('DROP INDEX IDX_1A98A733F720C233 ON sylius_plus_return_request_unit');
    }
}
