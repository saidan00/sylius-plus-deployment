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

final class Version20190103134228 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_invoicing_plugin_invoice ADD shopBillingData_company VARCHAR(255) DEFAULT NULL, ADD shopBillingData_tax_id VARCHAR(255) DEFAULT NULL, ADD shopBillingData_street VARCHAR(255) DEFAULT NULL, ADD shopBillingData_city VARCHAR(255) DEFAULT NULL, ADD shopBillingData_postcode VARCHAR(255) DEFAULT NULL, ADD shopBillingData_country_code VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_invoicing_plugin_invoice DROP shopBillingData_company, DROP shopBillingData_tax_id, DROP shopBillingData_street, DROP shopBillingData_city, DROP shopBillingData_postcode, DROP shopBillingData_country_code');
    }
}
