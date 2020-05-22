<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190710085620 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_plus_return_request ADD number VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX number_order_number_idx ON sylius_plus_return_request (number, order_number)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX number_order_number_idx ON sylius_plus_return_request');
        $this->addSql('ALTER TABLE sylius_plus_return_request DROP number');
    }
}
