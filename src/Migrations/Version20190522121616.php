<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190522121616 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_plus_user_pool (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D388EDEE77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO sylius_plus_user_pool (id, code) VALUES (1, \'default\')');

        $this->addSql('ALTER TABLE sylius_shop_user ADD user_pool_id INT DEFAULT NULL');
        $this->addSql('UPDATE sylius_shop_user SET user_pool_id = 1');
        $this->addSql('ALTER TABLE sylius_shop_user MODIFY user_pool_id INT NOT NULL');
        $this->addSql('ALTER TABLE sylius_shop_user ADD CONSTRAINT FK_7C2B7480233918D5 FOREIGN KEY (user_pool_id) REFERENCES sylius_plus_user_pool (id)');
        $this->addSql('CREATE INDEX IDX_7C2B7480233918D5 ON sylius_shop_user (user_pool_id)');

        $this->addSql('ALTER TABLE sylius_channel ADD user_pool_id INT DEFAULT NULL');
        $this->addSql('UPDATE sylius_channel SET user_pool_id = 1');
        $this->addSql('ALTER TABLE sylius_channel MODIFY user_pool_id INT NOT NULL');
        $this->addSql('ALTER TABLE sylius_channel ADD CONSTRAINT FK_16C8119E233918D5 FOREIGN KEY (user_pool_id) REFERENCES sylius_plus_user_pool (id)');
        $this->addSql('CREATE INDEX IDX_16C8119E233918D5 ON sylius_channel (user_pool_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_shop_user DROP FOREIGN KEY FK_7C2B7480233918D5');
        $this->addSql('ALTER TABLE sylius_channel DROP FOREIGN KEY FK_16C8119E233918D5');
        $this->addSql('DROP TABLE sylius_plus_user_pool');
        $this->addSql('DROP INDEX IDX_16C8119E233918D5 ON sylius_channel');
        $this->addSql('ALTER TABLE sylius_channel DROP user_pool_id');
        $this->addSql('DROP INDEX IDX_7C2B7480233918D5 ON sylius_shop_user');
        $this->addSql('ALTER TABLE sylius_shop_user DROP user_pool_id');
    }
}
