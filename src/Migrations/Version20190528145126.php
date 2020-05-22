<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190528145126 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_channel ADD business_unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_channel ADD CONSTRAINT FK_16C8119EA58ECB40 FOREIGN KEY (business_unit_id) REFERENCES sylius_business_unit (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16C8119EA58ECB40 ON sylius_channel (business_unit_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_channel DROP FOREIGN KEY FK_16C8119EA58ECB40');
        $this->addSql('DROP INDEX UNIQ_16C8119EA58ECB40 ON sylius_channel');
        $this->addSql('ALTER TABLE sylius_channel DROP business_unit_id');
    }
}
