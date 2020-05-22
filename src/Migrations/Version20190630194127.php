<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190630194127 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_plus_return_request_items (return_request_id VARCHAR(255) NOT NULL, return_request_unit_id INT NOT NULL, INDEX IDX_AC6AABBE89EA1297 (return_request_id), INDEX IDX_AC6AABBEF9BA0E74 (return_request_unit_id), PRIMARY KEY(return_request_id, return_request_unit_id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_plus_return_request_unit (id INT AUTO_INCREMENT NOT NULL, product_unit_id INT NOT NULL, product_unit_name VARCHAR(255) NOT NULL, product_unit_price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_plus_return_request_items ADD CONSTRAINT FK_AC6AABBE89EA1297 FOREIGN KEY (return_request_id) REFERENCES sylius_plus_return_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_plus_return_request_items ADD CONSTRAINT FK_AC6AABBEF9BA0E74 FOREIGN KEY (return_request_unit_id) REFERENCES sylius_plus_return_request_unit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_plus_return_request ADD currencyCode VARCHAR(255) NOT NULL, DROP return_all');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_plus_return_request_items DROP FOREIGN KEY FK_AC6AABBEF9BA0E74');
        $this->addSql('DROP TABLE sylius_plus_return_request_items');
        $this->addSql('DROP TABLE sylius_plus_return_request_unit');
        $this->addSql('ALTER TABLE sylius_plus_return_request ADD return_all TINYINT(1) NOT NULL, DROP currencyCode');
    }
}
