<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Entity\LupaExportableIdsInterface;
use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\ExportToLupa;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<ExportToLupa>
 */
interface ExportToLupaFactoryInterface extends FactoryInterface
{
    public function createNew(): ExportToLupa;

    /**
     * @param LupaExportableIdsInterface[] $lupaExportableIds
     */
    public function createForImporting(array $lupaExportableIds): ExportToLupa;
}
