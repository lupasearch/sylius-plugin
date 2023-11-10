<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQueryConfigurationInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<SearchQueryConfigurationInterface>
 */
interface SearchQueryConfigurationFactoryInterface extends FactoryInterface
{
    public function createNew(): SearchQueryConfigurationInterface;
}
