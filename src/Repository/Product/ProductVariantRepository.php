<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Repository\Product;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTaxonInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Product\Model\ProductAttributeInterface;
use Sylius\Component\Product\Model\ProductAttributeValueInterface;
use Webmozart\Assert\Assert;

/**
 * @extends ServiceEntityRepository<ProductVariantInterface>
 */
class ProductVariantRepository extends ServiceEntityRepository implements ProductVariantRepositoryInterface
{
    public function findEnabledByIds(array $ids): array
    {
        /** @var ProductVariantInterface[] */
        return $this->createQueryBuilder('product_variant')
            ->select('product_variant')
            ->distinct()
            ->where('product_variant.id IN (:ids)')
            ->andWhere('product_variant.enabled = true')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }

    public function findAllEnabledInBatches(int $limit, int $offset): array
    {
        /** @var ProductVariantInterface[] */
        return $this->createQueryBuilder('product_variant')
            ->andWhere('product_variant.enabled = true')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function findAllEnabledIdsByTaxonCode(string $taxonCode): array
    {
        $qb = $this->createQueryBuilder('product_variant');

        $query = $qb
            ->select('product_variant.id')
            ->distinct()
            ->from(ProductInterface::class, 'product')
            ->from(ProductTaxonInterface::class, 'productTaxon')
            ->from(TaxonInterface::class, 'taxon')
            ->andWhere('taxon.code = :taxonCode')
            ->setParameter('taxonCode', $taxonCode)
            ->andWhere($qb->expr()->orX(
                $qb->expr()->eq('product.mainTaxon', 'taxon'),
                $qb->expr()->andX(
                    $qb->expr()->eq('productTaxon.taxon', 'taxon'),
                    $qb->expr()->eq('productTaxon.product', 'product'),
                ),
            ))
            ->andWhere('product_variant.product = product')
            ->andWhere('product_variant.enabled = true')
            ->getQuery();

        $result = $query->getSingleColumnResult();
        Assert::allInteger($result);

        return $result;
    }

    public function findAllEnabledIdsByAttributeCode(string $attributeCode): array
    {
        $result = $this->createQueryBuilder('product_variant')
            ->select('product_variant.id')
            ->distinct()
            ->innerJoin(ProductAttributeInterface::class, 'productAttribute', Join::WITH)
            ->innerJoin(ProductAttributeValueInterface::class, 'attributeValue', Join::WITH, 'attributeValue.attribute = productAttribute')
            ->innerJoin(ProductInterface::class, 'product', Join::WITH, 'attributeValue.subject = product')
            ->andWhere('product_variant.product = product')
            ->andWhere('product_variant.enabled = true')
            ->andWhere('productAttribute.code = :attributeCode')
            ->setParameter('attributeCode', $attributeCode)
            ->getQuery()
            ->getSingleColumnResult();

        Assert::allInteger($result);

        return $result;
    }

    public function findAllEnabledIdsByOptionCode(string $optionCode): array
    {
        $result = $this->createQueryBuilder('product_variant')
            ->select('product_variant.id')
            ->distinct()
            ->join('product_variant.optionValues', 'optionValue')
            ->join('optionValue.option', 'productOption')
            ->andWhere('product_variant.enabled = true')
            ->andWhere('productOption.code = :optionCode')
            ->setParameter('optionCode', $optionCode)
            ->getQuery()
            ->getSingleColumnResult();

        Assert::allInteger($result);

        return $result;
    }

    public function findAllEnabledIdsByOptionValueCode(string $optionValueCode): array
    {
        $result = $this->createQueryBuilder('product_variant')
            ->select('product_variant.id')
            ->distinct()
            ->join('product_variant.optionValues', 'optionValue')
            ->andWhere('product_variant.enabled = true')
            ->andWhere('optionValue.code = :optionValueCode')
            ->setParameter('optionValueCode', $optionValueCode)
            ->getQuery()
            ->getSingleColumnResult();

        Assert::allInteger($result);

        return $result;
    }
}
