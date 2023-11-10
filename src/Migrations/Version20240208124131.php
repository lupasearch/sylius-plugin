<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240208124131 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE lupasearch_lupa_exportable_ids (id INT AUTO_INCREMENT NOT NULL, product_variant_to_add_id INT DEFAULT NULL, product_variant_to_remove_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE lupasearch_lupa_exportable_ids');
    }
}
