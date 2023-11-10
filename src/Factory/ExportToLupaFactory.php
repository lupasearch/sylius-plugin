<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\ExportToLupa;

class ExportToLupaFactory implements ExportToLupaFactoryInterface
{
    public function createNew(): ExportToLupa
    {
        return new ExportToLupa([]);
    }

    public function createForImporting(array $lupaExportableIds): ExportToLupa
    {
        return new ExportToLupa($lupaExportableIds);
    }
}
