<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Enum;

enum FacetType: string
{
    case Terms = 'terms';
    case Stats = 'stats';
    case Range = 'range';
    case Hierarchy = 'hierarchy';
}
