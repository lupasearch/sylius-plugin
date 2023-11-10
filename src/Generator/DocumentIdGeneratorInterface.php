<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Generator;

use Sylius\Component\Core\Model\ProductVariantInterface;

interface DocumentIdGeneratorInterface
{
    public function generateFromVariant(ProductVariantInterface $productVariant): string;
}
