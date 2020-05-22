<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190903140026 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_7E82D5E6A0D96FBF ON sylius_customer');
        $this->addSql('DROP INDEX UNIQ_7E82D5E6E7927C74 ON sylius_customer');

        $this->addSql('ALTER TABLE sylius_customer ADD user_pool_id INT DEFAULT NULL');
        $this->addSql('UPDATE sylius_customer SET user_pool_id = 1');
        $this->addSql('ALTER TABLE sylius_customer MODIFY user_pool_id INT NOT NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD CONSTRAINT FK_7E82D5E6233918D5 FOREIGN KEY (user_pool_id) REFERENCES sylius_plus_user_pool (id)');

        $this->addSql('CREATE INDEX IDX_7E82D5E6233918D5 ON sylius_customer (user_pool_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E82D5E6E7927C74233918D5 ON sylius_customer (email, user_pool_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E82D5E6A0D96FBF233918D5 ON sylius_customer (email_canonical, user_pool_id)');
        $this->addSql('ALTER TABLE sylius_shop_user DROP INDEX IDX_7C2B74809395C3F3, ADD UNIQUE INDEX UNIQ_7C2B74809395C3F3 (customer_id)');
        $this->addSql('ALTER TABLE sylius_shop_user DROP FOREIGN KEY FK_7C2B7480233918D5');
        $this->addSql('DROP INDEX IDX_7C2B7480233918D5 ON sylius_shop_user');
        $this->addSql('ALTER TABLE sylius_shop_user DROP user_pool_id');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_customer DROP FOREIGN KEY FK_7E82D5E6233918D5');
        $this->addSql('DROP INDEX IDX_7E82D5E6233918D5 ON sylius_customer');
        $this->addSql('DROP INDEX UNIQ_7E82D5E6E7927C74233918D5 ON sylius_customer');
        $this->addSql('DROP INDEX UNIQ_7E82D5E6A0D96FBF233918D5 ON sylius_customer');
        $this->addSql('ALTER TABLE sylius_customer DROP user_pool_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E82D5E6A0D96FBF ON sylius_customer (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E82D5E6E7927C74 ON sylius_customer (email)');

        $this->addSql('ALTER TABLE sylius_shop_user DROP INDEX UNIQ_7C2B74809395C3F3, ADD INDEX IDX_7C2B74809395C3F3 (customer_id)');
        $this->addSql('ALTER TABLE sylius_shop_user ADD user_pool_id INT DEFAULT NULL');
        $this->addSql('UPDATE sylius_shop_user SET user_pool_id = 1');
        $this->addSql('ALTER TABLE sylius_shop_user MODIFY user_pool_id INT NOT NULL');
        $this->addSql('ALTER TABLE sylius_shop_user ADD CONSTRAINT FK_7C2B7480233918D5 FOREIGN KEY (user_pool_id) REFERENCES sylius_plus_user_pool (id) ON UPDATE NO ACTION ON DELETE NO ACTION');

        $this->addSql('CREATE INDEX IDX_7C2B7480233918D5 ON sylius_shop_user (user_pool_id)');
    }
}
