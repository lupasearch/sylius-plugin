<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Model\FacetInterface;
use InvalidArgumentException;
use Sylius\Component\Product\Model\ProductOptionInterface;

interface FromOptionToFacetTransformerInterface
{
    /**
     * @throws InvalidArgumentException If the options code or name is null
     */
    public function transform(ProductOptionInterface $productOption): FacetInterface;
}
