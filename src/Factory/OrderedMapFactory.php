<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\OrderedMap;
use LupaSearch\SyliusLupaSearchPlugin\Model\OrderedMapInterface;

class OrderedMapFactory implements OrderedMapFactoryInterface
{
    public function createNew(): OrderedMapInterface
    {
        return new OrderedMap();
    }
}
