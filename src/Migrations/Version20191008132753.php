<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191008132753 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_channel DROP FOREIGN KEY FK_16C8119E233918D5');
        $this->addSql('ALTER TABLE sylius_customer DROP FOREIGN KEY FK_7E82D5E6233918D5');

        $this->addSql('CREATE TABLE sylius_plus_customer_pool (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_503F870E77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO sylius_plus_customer_pool (id, code, name) VALUES (1, \'default\', \'Default\')');
        $this->addSql('DROP TABLE sylius_plus_user_pool');

        $this->addSql('ALTER TABLE sylius_plus_return_request_unit CHANGE state state VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX IDX_16C8119E233918D5 ON sylius_channel');
        $this->addSql('ALTER TABLE sylius_channel CHANGE user_pool_id customer_pool_id INT NOT NULL');
        $this->addSql('ALTER TABLE sylius_channel ADD CONSTRAINT FK_16C8119E67E9A261 FOREIGN KEY (customer_pool_id) REFERENCES sylius_plus_customer_pool (id)');
        $this->addSql('CREATE INDEX IDX_16C8119E67E9A261 ON sylius_channel (customer_pool_id)');
        $this->addSql('DROP INDEX UNIQ_7E82D5E6A0D96FBF233918D5 ON sylius_customer');
        $this->addSql('DROP INDEX IDX_7E82D5E6233918D5 ON sylius_customer');
        $this->addSql('DROP INDEX UNIQ_7E82D5E6E7927C74233918D5 ON sylius_customer');
        $this->addSql('ALTER TABLE sylius_customer CHANGE user_pool_id customer_pool_id INT NOT NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD CONSTRAINT FK_7E82D5E667E9A261 FOREIGN KEY (customer_pool_id) REFERENCES sylius_plus_customer_pool (id)');
        $this->addSql('CREATE INDEX IDX_7E82D5E667E9A261 ON sylius_customer (customer_pool_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E82D5E6E7927C7467E9A261 ON sylius_customer (email, customer_pool_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E82D5E6A0D96FBF67E9A261 ON sylius_customer (email_canonical, customer_pool_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_channel DROP FOREIGN KEY FK_16C8119E67E9A261');
        $this->addSql('ALTER TABLE sylius_customer DROP FOREIGN KEY FK_7E82D5E667E9A261');

        $this->addSql('CREATE TABLE sylius_plus_user_pool (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_D388EDEE77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('INSERT INTO sylius_plus_user_pool (id, code, name) VALUES (1, \'default\', \'Default\')');
        $this->addSql('DROP TABLE sylius_plus_customer_pool');

        $this->addSql('DROP INDEX IDX_16C8119E67E9A261 ON sylius_channel');
        $this->addSql('ALTER TABLE sylius_channel CHANGE customer_pool_id user_pool_id INT NOT NULL');
        $this->addSql('ALTER TABLE sylius_channel ADD CONSTRAINT FK_16C8119E233918D5 FOREIGN KEY (user_pool_id) REFERENCES sylius_plus_user_pool (id)');
        $this->addSql('CREATE INDEX IDX_16C8119E233918D5 ON sylius_channel (user_pool_id)');
        $this->addSql('DROP INDEX IDX_7E82D5E667E9A261 ON sylius_customer');
        $this->addSql('DROP INDEX UNIQ_7E82D5E6E7927C7467E9A261 ON sylius_customer');
        $this->addSql('DROP INDEX UNIQ_7E82D5E6A0D96FBF67E9A261 ON sylius_customer');
        $this->addSql('ALTER TABLE sylius_customer CHANGE customer_pool_id user_pool_id INT NOT NULL');
        $this->addSql('ALTER TABLE sylius_customer ADD CONSTRAINT FK_7E82D5E6233918D5 FOREIGN KEY (user_pool_id) REFERENCES sylius_plus_user_pool (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E82D5E6A0D96FBF233918D5 ON sylius_customer (email_canonical, user_pool_id)');
        $this->addSql('CREATE INDEX IDX_7E82D5E6233918D5 ON sylius_customer (user_pool_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7E82D5E6E7927C74233918D5 ON sylius_customer (email, user_pool_id)');
        $this->addSql('ALTER TABLE sylius_plus_return_request_unit CHANGE state state VARCHAR(255) DEFAULT \'new\' NOT NULL COLLATE utf8_unicode_ci');
    }
}
