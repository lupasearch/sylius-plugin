<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQueryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @extends FactoryInterface<SearchQueryInterface>
 */
interface SearchQueryFactoryInterface extends FactoryInterface
{
    public function createNew(): SearchQueryInterface;
}
