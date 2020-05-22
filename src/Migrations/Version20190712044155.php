<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190712044155 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX number_order_number_idx ON sylius_plus_return_request');
        $this->addSql('ALTER TABLE sylius_plus_return_request ADD order_id INT DEFAULT NULL, DROP order_number');
        $this->addSql('ALTER TABLE sylius_plus_return_request ADD CONSTRAINT FK_164D478D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_164D478D9F6D38 ON sylius_plus_return_request (order_id)');
        $this->addSql('CREATE UNIQUE INDEX number_order_id_idx ON sylius_plus_return_request (number, order_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_plus_return_request DROP FOREIGN KEY FK_164D478D9F6D38');
        $this->addSql('DROP INDEX IDX_164D478D9F6D38 ON sylius_plus_return_request');
        $this->addSql('DROP INDEX number_order_id_idx ON sylius_plus_return_request');
        $this->addSql('ALTER TABLE sylius_plus_return_request ADD order_number VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP order_id');
        $this->addSql('CREATE UNIQUE INDEX number_order_number_idx ON sylius_plus_return_request (number, order_number)');
    }
}
