<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Api;

use LupaSearch\SyliusLupaSearchPlugin\Model\SearchQueryInterface;

interface SearchQueriesApiManagerInterface
{
    public function updateSearchQuery(SearchQueryInterface $initialSearchQuery): void;

    public function getSearchQuery(): SearchQueryInterface;
}
