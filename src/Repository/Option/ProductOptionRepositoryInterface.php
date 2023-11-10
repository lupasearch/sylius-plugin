<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Repository\Option;

use Doctrine\Persistence\ObjectRepository;
use Sylius\Component\Product\Model\ProductOptionInterface;

/**
 * @extends ObjectRepository<ProductOptionInterface>
 */
interface ProductOptionRepositoryInterface extends ObjectRepository
{
    /**
     * @return ProductOptionInterface[]
     */
    public function findAllOptionsWithTranslationsInBatches(int $limit, int $offset): array;
}
