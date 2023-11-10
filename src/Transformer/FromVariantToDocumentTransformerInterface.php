<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentInterface;
use LupaSearch\SyliusLupaSearchPlugin\Model\DocumentsInterface;
use InvalidArgumentException;
use Sylius\Component\Core\Model\ProductVariantInterface;

interface FromVariantToDocumentTransformerInterface
{
    /**
     * @throws InvalidArgumentException If the variants one of the property is null
     */
    public function transform(ProductVariantInterface $productVariant): DocumentInterface;

    /**
     * @param ProductVariantInterface[] $productVariants
     */
    public function transformAll(array $productVariants): DocumentsInterface;
}
