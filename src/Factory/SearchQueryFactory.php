<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Factory;

use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQuery;
use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQueryInterface;

class SearchQueryFactory implements SearchQueryFactoryInterface
{
    public function createNew(): SearchQueryInterface
    {
        return new SearchQuery();
    }
}
