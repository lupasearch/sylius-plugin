<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\OrderedMapInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<OrderedMapInterface>
 */
interface OrderedMapFactoryInterface extends FactoryInterface
{
    public function createNew(): OrderedMapInterface;
}
