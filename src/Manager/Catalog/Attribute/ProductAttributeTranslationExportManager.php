<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Attribute;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Product\Model\ProductAttributeInterface;
use Sylius\Component\Product\Model\ProductAttributeTranslationInterface;
use Webmozart\Assert\Assert;

/**
 * @implements LupaExportManagerInterface<ProductAttributeTranslationInterface>
 */
class ProductAttributeTranslationExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly ProductVariantRepositoryInterface $productVariantRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductAttributeTranslationInterface;
    }

    public function export(object $object): void
    {
        $productAttribute = $object->getTranslatable();
        Assert::isInstanceOf($productAttribute, ProductAttributeInterface::class);
        if (null === $productAttribute->getCode()) {
            $this->logger->warning(
                sprintf('Product attribute with id %s has no code', $productAttribute->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByAttributeCode($productAttribute->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }

    public function delete(object $object): void
    {
        $productAttribute = $object->getTranslatable();
        Assert::isInstanceOf($productAttribute, ProductAttributeInterface::class);
        if (null === $productAttribute->getCode()) {
            $this->logger->warning(
                sprintf('Product attribute with id %s has no code', $productAttribute->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByAttributeCode($productAttribute->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }
}
