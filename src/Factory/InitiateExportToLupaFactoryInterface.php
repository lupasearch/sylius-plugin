<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Messenger\Command\InitiateExportToLupa;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<InitiateExportToLupa>
 */
interface InitiateExportToLupaFactoryInterface extends FactoryInterface
{
    public function createNew(): InitiateExportToLupa;
}
