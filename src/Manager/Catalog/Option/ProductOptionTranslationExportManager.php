<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Option;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use LupaSearch\SyliusLupaSearchPlugin\Repository\Product\ProductVariantRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Product\Model\ProductOptionInterface;
use Sylius\Component\Product\Model\ProductOptionTranslationInterface;
use Webmozart\Assert\Assert;

/**
 * @implements LupaExportManagerInterface<ProductOptionTranslationInterface>
 */
class ProductOptionTranslationExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly ProductVariantRepositoryInterface $productVariantRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductOptionTranslationInterface;
    }

    public function export(object $object): void
    {
        $productOption = $object->getTranslatable();

        Assert::isInstanceOf($productOption, ProductOptionInterface::class);
        if (null === $productOption->getCode()) {
            $this->logger->warning(
                sprintf('Product option translation with id %s has no code', $object->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByOptionCode($productOption->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }

    public function delete(object $object): void
    {
        $productOption = $object->getTranslatable();

        Assert::isInstanceOf($productOption, ProductOptionInterface::class);
        if (null === $productOption->getCode()) {
            $this->logger->warning(
                sprintf('Product option translation with id %s has no code', $object->getId()),
            );

            return;
        }

        $variants = $this->productVariantRepository->findAllEnabledIdsByOptionCode($productOption->getCode());
        foreach ($variants as $variantId) {
            $this->lupaContext->addProductVariantIdToAdd($variantId);
        }
    }
}
