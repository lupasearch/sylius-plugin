<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240208124131 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE lupasearch_exportable_ids (id INT AUTO_INCREMENT NOT NULL, id_to_add INT DEFAULT NULL, id_to_remove INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE INDEX id_to_add ON lupasearch_exportable_ids (id_to_add)');
        $this->addSql('CREATE INDEX id_to_remove ON lupasearch_exportable_ids (id_to_remove)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX id_to_add ON lupasearch_exportable_ids');
        $this->addSql('DROP INDEX id_to_remove ON lupasearch_exportable_ids');
        $this->addSql('DROP TABLE lupasearch_exportable_ids');
    }
}
