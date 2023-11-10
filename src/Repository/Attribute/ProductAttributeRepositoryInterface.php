<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Repository\Attribute;

use Doctrine\Persistence\ObjectRepository;
use Sylius\Component\Product\Model\ProductAttributeInterface;

/**
 * @extends ObjectRepository<ProductAttributeInterface>
 */
interface ProductAttributeRepositoryInterface extends ObjectRepository
{
    /**
     * @return ProductAttributeInterface[]
     */
    public function findAllAttributesWithTranslationsInBatches(int $limit, int $offset): array;
}
