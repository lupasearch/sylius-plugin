<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Attribute;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Product\Model\ProductAttributeValueInterface;

/**
 * @implements LupaExportManagerInterface<ProductAttributeValueInterface>
 */
class ProductAttributeValueExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly ProductVariantRepositoryInterface $productVariantRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductAttributeValueInterface;
    }

    public function export(object $object): void
    {
        if (null === $object->getCode()) {
            $this->logger->warning(
                sprintf('Product attribute value with id %s has no code', $object->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByAttributeCode($object->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }

    public function delete(object $object): void
    {
        if (null === $object->getCode()) {
            $this->logger->warning(
                sprintf('Product attribute value with id %s has no code', $object->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByAttributeCode($object->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }
}
