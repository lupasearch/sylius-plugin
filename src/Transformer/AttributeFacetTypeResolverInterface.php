<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Enum\FacetType;

interface AttributeFacetTypeResolverInterface
{
    public function resolve(string $attributeType): FacetType;
}
