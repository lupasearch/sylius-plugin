<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\QueueExportToLupa;

class QueueExportToLupaFactory implements QueueExportToLupaFactoryInterface
{
    public function createNew(): QueueExportToLupa
    {
        return new QueueExportToLupa([], []);
    }

    public function createForImporting(array $productVariantsIds): QueueExportToLupa
    {
        return new QueueExportToLupa($productVariantsIds, []);
    }

    public function createForRemoving(array $productVariantsIds): QueueExportToLupa
    {
        return new QueueExportToLupa([], $productVariantsIds);
    }
}
