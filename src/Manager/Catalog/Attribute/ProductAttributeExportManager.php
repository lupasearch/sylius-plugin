<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Attribute;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Product\Model\ProductAttributeInterface;

/**
 * @implements LupaExportManagerInterface<ProductAttributeInterface>
 */
class ProductAttributeExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly ProductVariantRepositoryInterface $productVariantRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductAttributeInterface;
    }

    public function export(object $object): void
    {
        if (null === $object->getCode()) {
            $this->logger->warning(
                sprintf('Product attribute with id %s has no code', $object->getId()),
            );

            return;
        }

        $variantsIds = $this->productVariantRepository->findAllEnabledIdsByAttributeCode($object->getCode());
        foreach ($variantsIds as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }

    public function delete(object $object): void
    {
        if (null === $object->getCode()) {
            $this->logger->warning(
                sprintf('Product attribute with id %s has no code', $object->getId()),
            );

            return;
        }

        $variantsIds = $this->productVariantRepository->findAllEnabledIdsByAttributeCode($object->getCode());
        foreach ($variantsIds as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }
}
