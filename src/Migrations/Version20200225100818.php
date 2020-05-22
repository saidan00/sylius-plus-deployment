<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200225100818 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_admin_user ADD channel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_admin_user ADD CONSTRAINT FK_88D5CC4D72F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id)');
        $this->addSql('CREATE INDEX IDX_88D5CC4D72F5A1AA ON sylius_admin_user (channel_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_admin_user DROP FOREIGN KEY FK_88D5CC4D72F5A1AA');
        $this->addSql('DROP INDEX IDX_88D5CC4D72F5A1AA ON sylius_admin_user');
        $this->addSql('ALTER TABLE sylius_admin_user DROP channel_id');
    }
}
