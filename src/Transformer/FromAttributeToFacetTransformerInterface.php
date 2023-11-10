<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Model\FacetInterface;
use InvalidArgumentException;
use Sylius\Component\Product\Model\ProductAttributeInterface;

interface FromAttributeToFacetTransformerInterface
{
    /**
     * @throws InvalidArgumentException If the attributes code or name is null
     */
    public function transform(ProductAttributeInterface $productAttribute): FacetInterface;
}
