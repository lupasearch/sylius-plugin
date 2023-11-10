<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Repository\Attribute;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Sylius\Component\Product\Model\ProductAttributeInterface;

/**
 * @extends ServiceEntityRepository<ProductAttributeInterface>
 */
class ProductAttributeRepository extends ServiceEntityRepository implements ProductAttributeRepositoryInterface
{
    public function findAllAttributesWithTranslationsInBatches(int $limit, int $offset): array
    {
        /** @var ProductAttributeInterface[] */
        return $this->createQueryBuilder('productAttribute')
            ->innerJoin('productAttribute.translations', 'translations')
            ->select('productAttribute', 'translations')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }
}
