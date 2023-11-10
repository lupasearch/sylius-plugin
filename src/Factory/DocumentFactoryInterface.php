<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<DocumentInterface>
 */
interface DocumentFactoryInterface extends FactoryInterface
{
    public function createNew(): DocumentInterface;
}
