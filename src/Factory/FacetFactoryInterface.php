<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\FacetInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<FacetInterface>
 */
interface FacetFactoryInterface extends FactoryInterface
{
    public function createNew(): FacetInterface;
}
