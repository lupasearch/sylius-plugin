<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Repository\Product;

use Doctrine\Persistence\ObjectRepository;
use Sylius\Component\Core\Model\ProductVariantInterface;

/**
 * @extends ObjectRepository<ProductVariantInterface>
 */
interface ProductVariantRepositoryInterface extends ObjectRepository
{
    /**
     * @param array<bool|int> $ids
     *
     * @return ProductVariantInterface[]
     */
    public function findEnabledByIds(array $ids): array;

    /**
     * @return ProductVariantInterface[]
     */
    public function findAllEnabledInBatches(int $limit, int $offset): array;

    /**
     * @return int[]
     */
    public function findAllEnabledIdsByTaxonCode(string $taxonCode): array;

    /**
     * @return int[]
     */
    public function findAllEnabledIdsByAttributeCode(string $attributeCode): array;

    /**
     * @return int[]
     */
    public function findAllEnabledIdsByOptionCode(string $optionCode): array;

    /**
     * @return int[]
     */
    public function findAllEnabledIdsByOptionValueCode(string $optionValueCode): array;
}
