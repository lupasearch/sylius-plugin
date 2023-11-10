<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\QueueExportToLupa;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<QueueExportToLupa>
 */
interface QueueExportToLupaFactoryInterface extends FactoryInterface
{
    public function createNew(): QueueExportToLupa;

    /**
     * @param int[] $productVariantsIds
     */
    public function createForImporting(array $productVariantsIds): QueueExportToLupa;

    /**
     * @param int[] $productVariantsIds
     */
    public function createForRemoving(array $productVariantsIds): QueueExportToLupa;
}
