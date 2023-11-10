<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Transformer;

use LupaSearch\SyliusLupaSearchPlugin\Model\BatchDeleteDocumentsInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;

interface FromVariantToBatchDeleteDocumentsTransformerInterface
{
    /**
     * @param ProductVariantInterface[] $productVariants
     */
    public function transform(array $productVariants): BatchDeleteDocumentsInterface;
}
