<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Repository\Option;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Sylius\Component\Product\Model\ProductOptionInterface;

/**
 * @extends ServiceEntityRepository<ProductOptionInterface>
 */
class ProductOptionRepository extends ServiceEntityRepository implements ProductOptionRepositoryInterface
{
    public function findAllOptionsWithTranslationsInBatches(int $limit, int $offset): array
    {
        /** @var ProductOptionInterface[] */
        return $this->createQueryBuilder('productOption')
            ->innerJoin('productOption.translations', 'translations')
            ->select('productOption', 'translations')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
