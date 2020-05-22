<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190904131604 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_plus_return_request_credit_memos (return_request_id VARCHAR(255) NOT NULL, credit_memo_id VARCHAR(255) NOT NULL, INDEX IDX_EA5B8F2F89EA1297 (return_request_id), INDEX IDX_EA5B8F2F8E574316 (credit_memo_id), PRIMARY KEY(return_request_id, credit_memo_id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_plus_return_request_credit_memos ADD CONSTRAINT FK_EA5B8F2F89EA1297 FOREIGN KEY (return_request_id) REFERENCES sylius_plus_return_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_plus_return_request_credit_memos ADD CONSTRAINT FK_EA5B8F2F8E574316 FOREIGN KEY (credit_memo_id) REFERENCES sylius_refund_credit_memo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_channel CHANGE return_requests_allowed return_requests_allowed TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sylius_plus_return_request_credit_memos');
        $this->addSql('ALTER TABLE sylius_channel CHANGE return_requests_allowed return_requests_allowed TINYINT(1) DEFAULT \'1\' NOT NULL');
    }
}
