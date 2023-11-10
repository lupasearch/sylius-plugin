<?php

declare(strict_types=1);

namespace LupaSearch\SyliusLupaSearchPlugin\Manager\Catalog\Product;

use LupaSearch\SyliusLupaSearchPlugin\Context\LupaExportContextInterface;
use LupaSearch\SyliusLupaSearchPlugin\Manager\LupaExportManagerInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;
use Webmozart\Assert\Assert;

/**
 * @implements LupaExportManagerInterface<ProductTranslationInterface>
 */
class ProductTranslationExportManager implements LupaExportManagerInterface
{
    public function __construct(
        private readonly LupaExportContextInterface $lupaContext,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function supports(object $object): bool
    {
        return $object instanceof ProductTranslationInterface;
    }

    public function export(object $object): void
    {
        $product = $object->getTranslatable();
        Assert::isInstanceOf($product, ProductInterface::class);
        foreach ($product->getVariants() as $variant) {
            if (null === $variant->getId()) {
                $this->logger->warning(
                    'Product variant has no id',
                );

                continue;
            }

            $this->lupaContext->addProductVariantIdToAdd($variant->getId());
        }
    }

    public function delete(object $object): void
    {
        $product = $object->getTranslatable();
        Assert::isInstanceOf($product, ProductInterface::class);
        foreach ($product->getVariants() as $variant) {
            if (null === $variant->getId()) {
                $this->logger->warning(
                    'Product variant has no id',
                );

                continue;
            }

            $this->lupaContext->addProductVariantIdToRemove($variant->getId());
        }
    }
}
