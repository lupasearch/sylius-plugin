<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Option;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Product\Model\ProductOptionValueInterface;
use Sylius\Component\Product\Model\ProductOptionValueTranslationInterface;
use Webmozart\Assert\Assert;

/**
 * @implements LupaExportManagerInterface<ProductOptionValueTranslationInterface>
 */
class ProductOptionValueTranslationExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly ProductVariantRepositoryInterface $productVariantRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductOptionValueTranslationInterface;
    }

    public function export(object $object): void
    {
        $productOptionValue = $object->getTranslatable();
        Assert::isInstanceOf($productOptionValue, ProductOptionValueInterface::class);
        if (null === $productOptionValue->getCode()) {
            $this->logger->warning(
                sprintf('Product option value translation with id %s has no code', $object->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByOptionValueCode(
            $productOptionValue->getCode(),
        );

        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }

    public function delete(object $object): void
    {
        $productOptionValue = $object->getTranslatable();
        Assert::isInstanceOf($productOptionValue, ProductOptionValueInterface::class);
        if (null === $productOptionValue->getCode()) {
            $this->logger->warning(
                sprintf('Product option value translation with id %s has no code', $object->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByOptionValueCode(
            $productOptionValue->getCode(),
        );

        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }
}
