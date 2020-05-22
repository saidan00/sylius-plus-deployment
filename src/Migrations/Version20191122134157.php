<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191122134157 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_plus_rbac_role_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_C70206BE2C2AC5D3 (translatable_id), UNIQUE INDEX sylius_plus_rbac_role_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_plus_rbac_role (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, permissions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_C3C5675377153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_plus_rbac_admin_user_roles (admin_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_DDFE6842642B8210 (admin_id), INDEX IDX_DDFE6842D60322AC (role_id), PRIMARY KEY(admin_id, role_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_plus_rbac_role_translation ADD CONSTRAINT FK_C70206BE2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_plus_rbac_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_plus_rbac_admin_user_roles ADD CONSTRAINT FK_DDFE6842642B8210 FOREIGN KEY (admin_id) REFERENCES sylius_admin_user (id)');
        $this->addSql('ALTER TABLE sylius_plus_rbac_admin_user_roles ADD CONSTRAINT FK_DDFE6842D60322AC FOREIGN KEY (role_id) REFERENCES sylius_plus_rbac_role (id)');
        $this->addSql('ALTER TABLE sylius_admin_user ADD enable_permission_checker TINYINT(1) DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_plus_rbac_role_translation DROP FOREIGN KEY FK_C70206BE2C2AC5D3');
        $this->addSql('ALTER TABLE sylius_plus_rbac_admin_user_roles DROP FOREIGN KEY FK_DDFE6842D60322AC');
        $this->addSql('DROP TABLE sylius_plus_rbac_role_translation');
        $this->addSql('DROP TABLE sylius_plus_rbac_role');
        $this->addSql('DROP TABLE sylius_plus_rbac_admin_user_roles');
        $this->addSql('ALTER TABLE sylius_admin_user DROP enable_permission_checker');
    }
}
