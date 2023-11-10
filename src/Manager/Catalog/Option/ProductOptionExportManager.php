<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Option;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;

/**
 * @implements LupaExportManagerInterface<ProductOptionInterface>
 */
class ProductOptionExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly ProductVariantRepositoryInterface $productVariantRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductOptionInterface;
    }

    public function export(object $object): void
    {
        if (null === $object->getCode()) {
            $this->logger->warning(
                sprintf('Product option with id %s has no code', $object->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByOptionCode($object->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }

    public function delete(object $object): void
    {
        if (null === $object->getCode()) {
            $this->logger->warning(
                sprintf('Product option with id %s has no code', $object->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByOptionCode($object->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }
}
