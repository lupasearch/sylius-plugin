<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQueryConfiguration;
use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQueryConfigurationInterface;

class SearchQueryConfigurationFactory implements SearchQueryConfigurationFactoryInterface
{
    public function createNew(): SearchQueryConfigurationInterface
    {
        return new SearchQueryConfiguration();
    }
}
