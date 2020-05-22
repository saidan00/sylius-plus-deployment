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

final class Version20180711084815 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_invoicing_plugin_sequence (id INTEGER NOT NULL, idx INTEGER NOT NULL, version INTEGER DEFAULT 1 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE sylius_invoicing_plugin_invoice ADD number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sylius_invoicing_plugin_sequence CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_invoicing_plugin_invoice DROP number');
        $this->addSql('ALTER TABLE sylius_invoicing_plugin_sequence CHANGE id id INT NOT NULL');
        $this->addSql('DROP TABLE sylius_invoicing_plugin_sequence');
    }
}
