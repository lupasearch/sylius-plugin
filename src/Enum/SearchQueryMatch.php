<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Enum;

enum SearchQueryMatch: string
{
    case Any = 'any';
    case All = 'all';
}
